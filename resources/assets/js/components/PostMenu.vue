<template>
	<div>
		<div v-if="modal != 'true'" class="dropdown">
			<button class="btn btn-link text-dark no-caret dropdown-toggle py-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" :title="$t('compose.postMenu.postOptions')">
				<span v-bind:class="[size =='lg' ? 'fas fa-ellipsis-v fa-lg text-muted' : 'fas fa-ellipsis-v fa-sm text-lighter']"></span>
			</button>
			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item font-weight-bold text-decoration-none" :href="status.url">{{ $t('compose.postMenu.goToPost') }}</a>
				<!-- <a class="dropdown-item font-weight-bold text-decoration-none" href="#">Share</a>
				<a class="dropdown-item font-weight-bold text-decoration-none" href="#">Embed</a> -->
				<span v-if="activeSession == true && statusOwner(status) == false">
					<a class="dropdown-item font-weight-bold" :href="reportUrl(status)">{{ $t('compose.common.report') }}</a>
				</span>
				<span v-if="activeSession == true && statusOwner(status) == true">
					<a class="dropdown-item font-weight-bold text-decoration-none" @click.prevent="muteProfile(status)">{{ $t('compose.postMenu.muteProfile') }}</a>
					<a class="dropdown-item font-weight-bold text-decoration-none" @click.prevent="blockProfile(status)">{{ $t('compose.postMenu.blockProfile') }}</a>
				</span>
				<span v-if="activeSession == true && profile.is_admin == true">
					<div class="dropdown-divider"></div>
					<a class="dropdown-item font-weight-bold text-danger text-decoration-none" v-on:click="deletePost(status)">{{ $t('common.delete') }}</a>
					<div class="dropdown-divider"></div>
					<h6 class="dropdown-header">{{ $t('compose.postMenu.modTools') }}</h6>
					<a class="dropdown-item font-weight-bold text-decoration-none" v-on:click="moderatePost(status, 'autocw')">
						<p class="mb-0">{{ $t('compose.postMenu.enforceCw') }}</p>
						<p class="mb-0  small text-muted"><i18n path="compose.postMenu.enforceCwDesc"><template v-slot:br><br></template></i18n></p>
					</a>
					<a class="dropdown-item font-weight-bold text-decoration-none" v-on:click="moderatePost(status, 'noautolink')">
						<p class="mb-0">{{ $t('compose.postMenu.noAutolinking') }}</p>
						<p class="mb-0 small text-muted"><i18n path="compose.postMenu.noAutolinkingDesc"><template v-slot:br><br></template></i18n></p>
					</a>
					<a class="dropdown-item font-weight-bold text-decoration-none" v-on:click="moderatePost(status, 'unlisted')">
						<p class="mb-0">{{ $t('compose.postMenu.unlistedPosts') }}</p>
						<p class="mb-0 small text-muted"><i18n path="compose.postMenu.unlistedPostsDesc"><template v-slot:br><br></template></i18n></p>
					</a>
					<a class="dropdown-item font-weight-bold text-decoration-none" v-on:click="moderatePost(status, 'disable')">
						<p class="mb-0">{{ $t('compose.postMenu.disableAccount') }}</p>
						<p class="mb-0 small text-muted"><i18n path="compose.postMenu.disableAccountDesc"><template v-slot:br><br></template></i18n></p>
					</a>
					<a class="dropdown-item font-weight-bold text-decoration-none" v-on:click="moderatePost(status, 'suspend')">
						<p class="mb-0">{{ $t('compose.postMenu.suspendAccount') }}</p>
						<p class="mb-0 small text-muted"><i18n path="compose.postMenu.suspendAccountDesc"><template v-slot:br><br></template></i18n></p>
					</a>

				</span>
			</div>
		</div>
		<div v-if="modal == 'true'">
			<span data-toggle="modal" :data-target="'#mt_pid_'+status.id">
				<span v-bind:class="[size =='lg' ? 'fas fa-ellipsis-v fa-lg text-muted' : 'fas fa-ellipsis-v fa-sm text-lighter']"></span>
			</span>
			<div class="modal" tabindex="-1" role="dialog" :id="'mt_pid_'+status.id">
				<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-body text-center">
							<div class="list-group">
								<a class="list-group-item text-dark text-decoration-none" :href="statusUrl(status)">{{ $t('compose.postMenu.goToPost') }}</a>
								<!-- a class="list-group-item font-weight-bold text-decoration-none" :href="status.url">Share</a>
								<a class="list-group-item font-weight-bold text-decoration-none" :href="status.url">Embed</a> -->
								<a class="list-group-item text-dark text-decoration-none" href="#" @click.prevent="hidePost(status)">{{ $t('compose.postMenu.hide') }}</a>
								<a v-if="activeSession == true && !statusOwner(status)" class="list-group-item text-danger font-weight-bold text-decoration-none" :href="reportUrl(status)">{{ $t('compose.common.report') }}</a>
								<div v-if="activeSession == true && statusOwner(status) == true || profile.is_admin == true" class="list-group-item text-danger font-weight-bold cursor-pointer" @click.prevent="deletePost">{{ $t('common.delete') }}</div>
								<a class="list-group-item text-lighter text-decoration-none" href="#" @click.prevent="closeModal()">{{ $t('common.close') }}</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<style type="text/css" scoped>
	.text-lighter {
		color:#B8C2CC !important;
	}
	.modal-body {
		padding: 0;
	}
</style>

<script type="text/javascript">
	export default {
		props: ['feed', 'status', 'profile', 'size', 'modal'],

		data() {
			return {
				activeSession: false
			};
		},

		mounted() {
			let el = document.querySelector('body');
			this.activeSession = el.classList.contains('loggedIn') ? true : false;
		},

		methods: {
			reportUrl(status) {
				let type = status.in_reply_to ? 'comment' : 'post';
				let id = status.id;
				return '/i/report?type=' + type + '&id=' + id;
			},

			timestampFormat(timestamp) {
				let ts = new Date(timestamp);
				return ts.toDateString() + ' ' + ts.toLocaleTimeString();
			},

			editUrl(status) {
				return status.url + '/edit';
			},

			redirect(url) {
				window.location.href = url;
				return;
			},

			replyUrl(status) {
				let username = this.profile.username;
				let id = status.account.id == this.profile.id ? status.id : status.in_reply_to_id;
				return '/p/' + username + '/' + id;
			},

			mentionUrl(status) {
				let username = status.account.username;
				let id = status.id;
				return '/p/' + username + '/' + id;
			},

			statusOwner(status) {
				let sid = parseInt(status.account.id);
				let uid = parseInt(this.profile.id);
				if(sid == uid) {
					return true;
				} else {
					return false;
				}
			},

			deletePost() {
				this.$emit('deletePost');
				$('#mt_pid_'+this.status.id).modal('hide');
			},

			hidePost(status) {
				status.sensitive = true;
				$('#mt_pid_'+status.id).modal('hide');
			},

			moderatePost(status, action, $event) {
				let username = status.account.username;
				switch(action) {
					case 'autocw':
						let msg = this.$t('compose.postMenu.enforceCwConfirm', { username: username });
						swal({
							title: this.$t('compose.postMenu.confirm'),
							text: msg,
							icon: 'warning',
							buttons: true,
							dangerMode: true
						});
					break;
					case 'suspend':
						msg = this.$t('compose.postMenu.suspendConfirm', { username: username });
						swal({
							title: this.$t('compose.postMenu.confirm'),
							text: msg,
							icon: 'warning',
							buttons: true,
							dangerMode: true
						});
					break;
				}
			},

			muteProfile(status) {
				if($('body').hasClass('loggedIn') == false) {
					return;
				}

				axios.post('/i/mute', {
					type: 'user',
					item: status.account.id
				}).then(res => {
					swal(this.$t('common.success'), this.$t('compose.postMenu.muted', { account: status.account.acct }), 'success');
				}).catch(err => {
					swal(this.$t('common.error'), this.$t('common.errorMsg'), 'error');
				});
			},

			blockProfile(status) {
				if($('body').hasClass('loggedIn') == false) {
					return;
				}

				axios.post('/i/block', {
					type: 'user',
					item: status.account.id
				}).then(res => {
					swal(this.$t('common.success'), this.$t('compose.postMenu.blocked', { account: status.account.acct }), 'success');
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

			closeModal() {
				$('#mt_pid_'+this.status.id).modal('hide');
			}
		}
	}
</script>
