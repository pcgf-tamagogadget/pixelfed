<template>
	<div class="context-menu-component modal-stack">
		<b-modal ref="ctxModal"
			id="ctx-modal"
			hide-header
			hide-footer
			centered
			rounded
			size="sm"
			body-class="list-group-flush p-0 rounded">
			<div class="list-group text-center">
				<!-- <div v-if="status && status.account.id != profile.id && ctxMenuRelationship && ctxMenuRelationship.following" class="list-group-item rounded cursor-pointer font-weight-bold text-danger" @click="ctxMenuUnfollow()">Unfollow</div>
				<div v-if="status && status.account.id != profile.id && ctxMenuRelationship && !ctxMenuRelationship.following" class="list-group-item rounded cursor-pointer font-weight-bold text-primary" @click="ctxMenuFollow()">Follow</div> -->
				<div v-if="status.visibility !== 'archived'" class="list-group-item rounded cursor-pointer" @click="ctxMenuGoToPost()">{{ $t('groups.contextMenu.viewPost') }}</div>
				<!-- <div v-if="status.visibility !== 'archived'" class="list-group-item rounded cursor-pointer" @click="ctxMenuGoToProfile()">View Profile</div> -->
				<!-- <div v-if="status && status.local == true && !status.in_reply_to_id" class="list-group-item rounded cursor-pointer" @click="ctxMenuEmbed()">Embed</div> -->
				<div class="list-group-item rounded cursor-pointer" @click="ctxMenuCopyLink()">{{ $t('common.copyLink') }}</div>
				<!-- <div v-if="status.visibility !== 'archived'" class="list-group-item rounded cursor-pointer" @click="ctxMenuShare()">Share</div> -->
				<!-- <div v-if="status && profile && profile.is_admin == true && status.visibility !== 'archived'" class="list-group-item rounded cursor-pointer" @click="ctxModMenuShow()">Moderation Tools</div> -->
				<div v-if="status && status.account.id != profile.id" class="list-group-item rounded cursor-pointer text-danger" @click="ctxMenuReportPost()">{{ $t('groups.contextMenu.report') }}</div>
				<div v-if="status && (profile.is_admin || profile.id == status.account.id) && status.visibility !== 'archived'" class="list-group-item rounded cursor-pointer text-danger" @click="deletePost(status)">{{ $t('common.delete') }}</div>
				<div class="list-group-item rounded cursor-pointer text-lighter" @click="closeCtxMenu()">{{ $t('common.cancel') }}</div>
			</div>
		</b-modal>
		<b-modal ref="ctxModModal"
			id="ctx-mod-modal"
			hide-header
			hide-footer
			centered
			rounded
			size="sm"
			body-class="list-group-flush p-0 rounded">
			<div class="list-group text-center">
				<p class="py-2 px-3 mb-0">
					<div class="text-center font-weight-bold text-danger">{{ $t('groups.contextMenu.moderationTools') }}</div>
					<div class="small text-center text-muted">{{ $t('groups.contextMenu.selectOption') }}</div>
				</p>
				<div class="list-group-item rounded cursor-pointer" @click="moderatePost(status, 'unlist')">{{ $t('groups.contextMenu.unlistFromTimelines') }}</div>
				<div v-if="status.sensitive" class="list-group-item rounded cursor-pointer" @click="moderatePost(status, 'remcw')">{{ $t('groups.contextMenu.removeContentWarning') }}</div>
				<div v-else class="list-group-item rounded cursor-pointer" @click="moderatePost(status, 'addcw')">{{ $t('groups.contextMenu.addContentWarning') }}</div>
				<div class="list-group-item rounded cursor-pointer" @click="moderatePost(status, 'spammer')">
					{{ $t('groups.contextMenu.markAsSpammer') }}<br />
					<span class="small">{{ $t('groups.contextMenu.markAsSpammerHelp') }}</span>
				</div>
				<!-- <div class="list-group-item rounded cursor-pointer" @click="ctxModOtherMenuShow()">Other</div> -->
				<div class="list-group-item rounded cursor-pointer text-lighter" @click="ctxModMenuClose()">{{ $t('common.cancel') }}</div>
			</div>
		</b-modal>
		<b-modal ref="ctxModOtherModal"
			id="ctx-mod-other-modal"
			hide-header
			hide-footer
			centered
			rounded
			size="sm"
			body-class="list-group-flush p-0 rounded">
			<div class="list-group text-center">
				<p class="py-2 px-3 mb-0">
					<div class="text-center font-weight-bold text-danger">{{ $t('groups.contextMenu.moderationTools') }}</div>
					<div class="small text-center text-muted">{{ $t('groups.contextMenu.selectOption') }}</div>
				</p>
				<div class="list-group-item rounded cursor-pointer font-weight-bold" @click="confirmModal()">{{ $t('groups.contextMenu.unlistPosts') }}</div>
				<div class="list-group-item rounded cursor-pointer font-weight-bold" @click="confirmModal()">{{ $t('groups.contextMenu.moderationLog') }}</div>
				<div class="list-group-item rounded cursor-pointer text-lighter" @click="ctxModOtherMenuClose()">{{ $t('common.cancel') }}</div>
			</div>
		</b-modal>
		<b-modal ref="ctxShareModal"
			id="ctx-share-modal"
			:title="$t('common.share')"
			hide-footer
			hide-header
			centered
			rounded
			size="sm"
			body-class="list-group-flush p-0 rounded text-center">
			<div class="list-group-item rounded cursor-pointer" @click="ctxMenuCopyLink()">{{ $t('common.copyLink') }}</div>
			<div class="list-group-item rounded cursor-pointer text-lighter" @click="closeCtxShareMenu()">{{ $t('common.cancel') }}</div>
		</b-modal>
		<b-modal ref="ctxEmbedModal"
			id="ctx-embed-modal"
			hide-header
			hide-footer
			centered
			rounded
			size="md"
			body-class="p-2 rounded">
			<div>
				<div class="form-group">
					<textarea class="form-control disabled text-monospace" rows="8" style="overflow-y:hidden;border: 1px solid #efefef; font-size: 12px; line-height: 18px; margin: 0 0 7px;resize:none;" v-model="ctxEmbedPayload" disabled=""></textarea>
				</div>
				<div class="form-group pl-2 d-flex justify-content-center">
					<div class="form-check mr-3">
						<input class="form-check-input" type="checkbox" v-model="ctxEmbedShowCaption" :disabled="ctxEmbedCompactMode == true">
						<label class="form-check-label font-weight-light">
							{{ $t('groups.contextMenu.showCaption') }}
						</label>
					</div>
					<div class="form-check mr-3">
						<input class="form-check-input" type="checkbox" v-model="ctxEmbedShowLikes" :disabled="ctxEmbedCompactMode == true">
						<label class="form-check-label font-weight-light">
							{{ $t('groups.contextMenu.showLikes') }}
						</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" v-model="ctxEmbedCompactMode">
						<label class="form-check-label font-weight-light">
							{{ $t('groups.contextMenu.compactMode') }}
						</label>
					</div>
				</div>
				<hr>
				<button :class="copiedEmbed ? 'btn btn-primary btn-block btn-sm py-1 font-weight-bold disabed': 'btn btn-primary btn-block btn-sm py-1 font-weight-bold'" @click="ctxCopyEmbed" :disabled="copiedEmbed">{{ copiedEmbed ? $t('groups.contextMenu.embedCodeCopied') : $t('groups.contextMenu.copyEmbedCode') }}</button>
				<p class="mb-0 px-2 small text-muted"><i18n path="groups.contextMenu.embedAgreement" tag="span"><template #terms><a href="/site/terms">{{ $t('groups.contextMenu.termsOfUse') }}</a></template></i18n></p>
			</div>
		</b-modal>
		<b-modal ref="ctxReport"
			id="ctx-report"
			hide-header
			hide-footer
			centered
			rounded
			size="sm"
			body-class="list-group-flush p-0 rounded">
			<p class="py-2 px-3 mb-0">
				<div class="text-center font-weight-bold text-danger">{{ $t('groups.contextMenu.report') }}</div>
				<div class="small text-center text-muted">{{ $t('groups.contextMenu.selectOption') }}</div>
			</p>
			<div class="list-group text-center">
				<div class="list-group-item rounded cursor-pointer font-weight-bold" @click="sendReport('spam')">{{ $t('groups.contextMenu.spam') }}</div>
				<div class="list-group-item rounded cursor-pointer font-weight-bold" @click="sendReport('sensitive')">{{ $t('common.sensitiveContent') }}</div>
				<div class="list-group-item rounded cursor-pointer font-weight-bold" @click="sendReport('abusive')">{{ $t('groups.contextMenu.abusive') }}</div>
				<div class="list-group-item rounded cursor-pointer font-weight-bold" @click="openCtxReportOtherMenu()">{{ $t('common.other') }}</div>
				<!-- <div class="list-group-item rounded cursor-pointer" @click="ctxReportMenuGoBack()">Go Back</div> -->
				<div class="list-group-item rounded cursor-pointer text-lighter" @click="ctxReportMenuGoBack()">{{ $t('common.cancel') }}</div>
			</div>
		</b-modal>
		<b-modal ref="ctxReportOther"
			id="ctx-report-other"
			hide-header
			hide-footer
			centered
			rounded
			size="sm"
			body-class="list-group-flush p-0 rounded">
			<p class="py-2 px-3 mb-0">
				<div class="text-center font-weight-bold text-danger">{{ $t('groups.contextMenu.report') }}</div>
				<div class="small text-center text-muted">{{ $t('groups.contextMenu.selectOption') }}</div>
			</p>
			<div class="list-group text-center">
				<div class="list-group-item rounded cursor-pointer font-weight-bold" @click="sendReport('underage')">{{ $t('groups.contextMenu.underage') }}</div>
				<div class="list-group-item rounded cursor-pointer font-weight-bold" @click="sendReport('copyright')">{{ $t('groups.contextMenu.copyright') }}</div>
				<div class="list-group-item rounded cursor-pointer font-weight-bold" @click="sendReport('impersonation')">{{ $t('groups.contextMenu.impersonation') }}</div>
				<div class="list-group-item rounded cursor-pointer font-weight-bold" @click="sendReport('scam')">{{ $t('groups.contextMenu.scam') }}</div>
				<!-- <div class="list-group-item rounded cursor-pointer font-weight-bold" @click="sendReport('terrorism')">Terrorism Related</div> -->
				<!-- <div class="list-group-item rounded cursor-pointer font-weight-bold" @click="sendReport('other')">Other or Not listed</div> -->
				<!-- <div class="list-group-item rounded cursor-pointer" @click="ctxReportOtherMenuGoBack()">Go Back</div> -->
				<div class="list-group-item rounded cursor-pointer text-lighter" @click="ctxReportOtherMenuGoBack()">{{ $t('common.cancel') }}</div>
			</div>
		</b-modal>
		<b-modal ref="ctxConfirm"
			id="ctx-confirm"
			hide-header
			hide-footer
			centered
			rounded
			size="sm"
			body-class="list-group-flush p-0 rounded">
			<div class="d-flex align-items-center justify-content-center py-3">
				<div>{{ this.confirmModalTitle }}</div>
			</div>
			<div class="d-flex border-top btn-group btn-group-block rounded-0" role="group">
				<button type="button" class="btn btn-outline-lighter border-left-0 border-top-0 border-bottom-0 border-right py-2" style="color: rgb(0,122,255) !important;" @click.prevent="confirmModalCancel()">{{ $t('common.cancel') }}</button>
				<button type="button" class="btn btn-outline-lighter border-0" style="color: rgb(0,122,255) !important;" @click.prevent="confirmModalConfirm()">{{ $t('groups.contextMenu.confirm') }}</button>
			</div>
		</b-modal>
	</div>
</template>

<script type="text/javascript">
	export default {
		props: {
			status: {
				type: Object
			},

			profile: {
				type: Object
			},

			type: {
				type: String,
				default: 'status',
				validator: (val) => ['status', 'comment', 'profile'].includes(val)
			},

			groupId: {
				type: String
			}
		},

		data() {
			return {
				ctxMenuStatus: false,
				ctxMenuRelationship: false,
				ctxEmbedPayload: false,
				copiedEmbed: false,
				replySending: false,
				ctxEmbedShowCaption: true,
				ctxEmbedShowLikes: false,
				ctxEmbedCompactMode: false,
				confirmModalTitle: this.$t('groups.contextMenu.areYouSure'),
				confirmModalIdentifer: null,
				confirmModalType: false,
			}
		},

		methods: {
			open() {
				this.ctxMenu();
			},

			ctxMenu() {
				this.ctxMenuStatus = this.status;
				this.ctxEmbedPayload = window.App.util.embed.post(this.status.url);
				if(this.status.account.id == this.profile.id) {
					this.ctxMenuRelationship = false;
					this.$refs.ctxModal.show();
				} else {
					axios.get('/api/pixelfed/v1/accounts/relationships', {
						params: {
							'id[]': this.status.account.id
						}
					}).then(res => {
						this.ctxMenuRelationship = res.data[0];
						this.$refs.ctxModal.show();
					});
				}
			},

			closeCtxMenu() {
				this.copiedEmbed = false;
				this.ctxMenuStatus = false;
				this.ctxMenuRelationship = false;
				this.$refs.ctxModal.hide();
				this.$refs.ctxReport.hide();
				this.$refs.ctxReportOther.hide();
				this.closeModals();
			},

			ctxMenuCopyLink() {
				let status = this.ctxMenuStatus;
				navigator.clipboard.writeText(status.url);
				this.closeModals();
				return;
			},

			ctxMenuGoToPost() {
				let status = this.ctxMenuStatus;
				window.location.href = this.statusUrl(status);
				this.closeCtxMenu();
				return;
			},

			ctxMenuGoToProfile() {
				let status = this.ctxMenuStatus;
				window.location.href = this.profileUrl(status);
				this.closeCtxMenu();
				return;
			},

			ctxMenuFollow() {
				let id = this.ctxMenuStatus.account.id;
				axios.post('/i/follow', {
					item: id
				}).then(res => {
					let username = this.ctxMenuStatus.account.acct;
					let title = this.$t('groups.contextMenu.followSuccess');
					let text = this.$t('groups.contextMenu.followSuccessMsg', { username: username });
					this.closeCtxMenu();
					setTimeout(function() {
						swal(title, text, 'success');
					}, 500);
				});
			},

			ctxMenuUnfollow() {
				let id = this.ctxMenuStatus.account.id;
				axios.post('/i/follow', {
					item: id
				}).then(res => {
					let username = this.ctxMenuStatus.account.acct;
					if(this.scope == 'home') {
						this.feed = this.feed.filter(s => {
							return s.account.id != this.ctxMenuStatus.account.id;
						});
					}
					let title = this.$t('groups.contextMenu.unfollowSuccess');
					let text = this.$t('groups.contextMenu.unfollowSuccessMsg', { username: username });
					this.closeCtxMenu();
					setTimeout(function() {
						swal(title, text, 'success');
					}, 500);
				});
			},

			ctxMenuReportPost() {
				this.$refs.ctxModal.hide();
				this.$refs.ctxReport.show();
				return;
			},

			ctxMenuEmbed() {
				this.closeModals();
				this.$refs.ctxEmbedModal.show();
			},

			ctxMenuShare() {
				this.$refs.ctxModal.hide();
				this.$refs.ctxShareModal.show();
			},

			closeCtxShareMenu() {
				this.$refs.ctxShareModal.hide();
				this.$refs.ctxModal.show();
			},

			ctxCopyEmbed() {
				navigator.clipboard.writeText(this.ctxEmbedPayload);
				this.ctxEmbedShowCaption = true;
				this.ctxEmbedShowLikes = false;
				this.ctxEmbedCompactMode = false;
				this.$refs.ctxEmbedModal.hide();
			},

			ctxModMenuShow() {
				this.$refs.ctxModal.hide();
				this.$refs.ctxModModal.show();
			},

			ctxModOtherMenuShow() {
				this.$refs.ctxModal.hide();
				this.$refs.ctxModModal.hide();
				this.$refs.ctxModOtherModal.show();
			},

			ctxModMenu() {
				this.$refs.ctxModal.hide();
			},

			ctxModMenuClose() {
				this.closeModals();
			},

			ctxModOtherMenuClose() {
				this.closeModals();
				this.$refs.ctxModModal.show();
			},

			formatCount(count) {
				return App.util.format.count(count);
			},

			openCtxReportOtherMenu() {
				let s = this.ctxMenuStatus;
				this.closeCtxMenu();
				this.ctxMenuStatus = s;
				this.$refs.ctxReportOther.show();
			},

			ctxReportMenuGoBack() {
				this.$refs.ctxReportOther.hide();
				this.$refs.ctxReport.hide();
				this.$refs.ctxModal.show();
			},

			ctxReportOtherMenuGoBack() {
				this.$refs.ctxReportOther.hide();
				this.$refs.ctxModal.hide();
				this.$refs.ctxReport.show();
			},

			sendReport(type) {
				let id = this.ctxMenuStatus.id;

				swal({
					'title': this.$t('groups.contextMenu.confirmReport'),
					'text': this.$t('groups.contextMenu.confirmReportMsg'),
					'icon': 'warning',
					'buttons': true,
					'dangerMode': true
				}).then((res) => {
					if(res) {
						axios.post(`/api/v0/groups/${this.groupId}/report/create`, {
							'type': type,
							'id': id,
						}).then(res => {
							this.closeCtxMenu();
							swal(this.$t('groups.contextMenu.reportSent'), this.$t('groups.contextMenu.reportSentMsg'), 'success');
						}).catch(err => {
							if(err.response.status == 422) {
								swal(this.$t('common.oops'), err.response.data.error, 'error');
							} else {
								swal(this.$t('common.oops'), this.$t('groups.contextMenu.reportError'), 'error');
							}
						})
					} else {
						this.closeCtxMenu();
					}
				});
			},

			closeModals() {
				this.$refs.ctxModal.hide();
				this.$refs.ctxModModal.hide();
				this.$refs.ctxModOtherModal.hide();
				this.$refs.ctxShareModal.hide();
				this.$refs.ctxEmbedModal.hide();
				this.$refs.ctxReport.hide();
				this.$refs.ctxReportOther.hide();
				this.$refs.ctxConfirm.hide();
			},

			openCtxStatusModal() {
				this.closeModals();
				this.$refs.ctxStatusModal.show();
			},

			openConfirmModal() {
				this.closeModals();
				this.$refs.ctxConfirm.show();
			},

			closeConfirmModal() {
				this.closeModals();
				this.confirmModalTitle = this.$t('groups.contextMenu.areYouSure');
				this.confirmModalType = false;
				this.confirmModalIdentifer = null;
			},

			confirmModalConfirm() {
				switch(this.confirmModalType) {
					case 'post.delete':
						axios.post('/i/delete', {
							type: 'status',
							item: this.confirmModalIdentifer
						}).then(res => {
							this.feed = this.feed.filter(s => {
								return s.id != this.confirmModalIdentifer;
							});
							this.closeConfirmModal();
						}).catch(err => {
							this.closeConfirmModal();
							swal(this.$t('common.error'), this.$t('common.errorMsg'), 'error');
						});
					break;
				}

				this.closeConfirmModal();
			},

			confirmModalCancel() {
				this.closeConfirmModal();
			},

			moderatePost(status, action, $event) {
				let username = status.account.username;
				let pid = status.id;
				let msg = '';
				let self = this;
				switch(action) {
					case 'addcw':
						msg = this.$t('groups.contextMenu.addCwConfirm');
						swal({
							title: this.$t('groups.contextMenu.confirm'),
							text: msg,
							icon: 'warning',
							buttons: true,
							dangerMode: true
						}).then(res =>  {
							if(res) {
								axios.post('/api/v2/moderator/action', {
									action: action,
									item_id: status.id,
									item_type: 'status'
								}).then(res => {
									swal(self.$t('common.success'), self.$t('groups.contextMenu.addCwSuccess'), 'success');
									status.sensitive = true;
									self.closeModals();
									self.ctxModMenuClose();
								}).catch(err => {
									swal(
										self.$t('common.error'),
										self.$t('common.errorMsg'),
										'error'
										);
									self.closeModals();
									self.ctxModMenuClose();
								});
							}
						});
					break;

					case 'remcw':
						msg = this.$t('groups.contextMenu.remCwConfirm');
						swal({
							title: this.$t('groups.contextMenu.confirm'),
							text: msg,
							icon: 'warning',
							buttons: true,
							dangerMode: true
						}).then(res =>  {
							if(res) {
								axios.post('/api/v2/moderator/action', {
									action: action,
									item_id: status.id,
									item_type: 'status'
								}).then(res => {
									swal(self.$t('common.success'), self.$t('groups.contextMenu.addCwSuccess'), 'success');
									status.sensitive = false;
									self.closeModals();
									self.ctxModMenuClose();
								}).catch(err => {
									swal(
										self.$t('common.error'),
										self.$t('common.errorMsg'),
										'error'
										);
									self.closeModals();
									self.ctxModMenuClose();
								});
							}
						});
					break;

					case 'unlist':
						msg = this.$t('groups.contextMenu.unlistConfirm');
						swal({
							title: this.$t('groups.contextMenu.confirm'),
							text: msg,
							icon: 'warning',
							buttons: true,
							dangerMode: true
						}).then(res =>  {
							if(res) {
								axios.post('/api/v2/moderator/action', {
									action: action,
									item_id: status.id,
									item_type: 'status'
								}).then(res => {
									this.feed = this.feed.filter(f => {
										return f.id != status.id;
									});
									swal(self.$t('common.success'), self.$t('groups.contextMenu.unlistSuccess'), 'success');
									self.closeModals();
									self.ctxModMenuClose();
								}).catch(err => {
									self.closeModals();
									self.ctxModMenuClose();
									swal(
										self.$t('common.error'),
										self.$t('common.errorMsg'),
										'error'
										);
								});
							}
						});
					break;

					case 'spammer':
						msg = this.$t('groups.contextMenu.spammerConfirm');
						swal({
							title: this.$t('groups.contextMenu.confirm'),
							text: msg,
							icon: 'warning',
							buttons: true,
							dangerMode: true
						}).then(res =>  {
							if(res) {
								axios.post('/api/v2/moderator/action', {
									action: action,
									item_id: status.id,
									item_type: 'status'
								}).then(res => {
									swal(self.$t('common.success'), self.$t('groups.contextMenu.spammerSuccess'), 'success');
									self.closeModals();
									self.ctxModMenuClose();
								}).catch(err => {
									self.closeModals();
									self.ctxModMenuClose();
									swal(
										self.$t('common.error'),
										self.$t('common.errorMsg'),
										'error'
										);
								});
							}
						});
					break;
				}
			},

			shareStatus(status, $event) {
				if($('body').hasClass('loggedIn') == false) {
					return;
				}

				this.closeModals();

				axios.post('/i/share', {
					item: status.id
				}).then(res => {
					status.reblogs_count = res.data.count;
					status.reblogged = !status.reblogged;
					if(status.reblogged) {
						swal(this.$t('common.success'), this.$t('groups.contextMenu.sharedPost'), 'success');
					} else {
						swal(this.$t('common.success'), this.$t('groups.contextMenu.unsharedPost'), 'success');
					}
				}).catch(err => {
					swal(this.$t('common.error'), this.$t('common.errorMsg'), 'error');
				});
			},

			statusUrl(status) {
				if(status.local == true) {
					return status.url;
				}

				return '/i/web/post/_/' + status.account.id + '/' + status.id;
			},

			profileUrl(status) {
				if(status.local == true) {
					return status.account.url;
				}

				return '/i/web/profile/_/' + status.account.id;
			},

			deletePost(status) {
				if($('body').hasClass('loggedIn') == false || this.ownerOrAdmin(status) == false) {
					return;
				}

				if(window.confirm(this.$t('groups.contextMenu.deleteConfirm')) == false) {
					return;
				}

				axios.post('/i/delete', {
					type: 'status',
					item: status.id
				}).then(res => {
					this.$emit('status-delete', status.id);
					this.closeModals();
				}).catch(err => {
					swal(this.$t('common.error'), this.$t('common.errorMsg'), 'error');
				});
			},

			owner(status) {
				return this.profile.id === status.account.id;
			},

			admin() {
				return this.profile.is_admin == true;
			},

			ownerOrAdmin(status) {
				return this.owner(status) || this.admin();
			},

			archivePost(status) {
				if(window.confirm(this.$t('groups.contextMenu.archiveConfirm')) == false) {
					return;
				}

				axios.post('/api/pixelfed/v2/status/' + status.id + '/archive')
				.then(res => {
					this.$emit('status-delete', status.id);
					this.closeModals();
				});
			},

			unarchivePost(status) {
				if(window.confirm(this.$t('groups.contextMenu.unarchiveConfirm')) == false) {
					return;
				}

				axios.post('/api/pixelfed/v2/status/' + status.id + '/unarchive')
				.then(res => {
					this.closeModals();
				});
			}
		}
	}
</script>
