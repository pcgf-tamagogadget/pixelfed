<template>
	<div>
		<b-modal
			v-if="profile && profile.hasOwnProperty('avatar')"
			ref="home"
			hide-footer
			centered
			rounded
			:title="$t('groups.memberLimitInteractionsModal.title')"
			body-class="rounded">

			<div class="media mb-3">
				<a :href="profile.url" class="text-dark text-decoration-none">
					<img :src="profile.avatar" width="56" height="56" class="rounded-circle border mr-2" />
				</a>

				<div class="media-body">
					<p class="lead font-weight-bold mb-0">
						<a :href="profile.url" class="text-dark text-decoration-none">{{profile.username}}</a>
						<span v-if="profile.role == 'founder'" class="member-label rounded ml-1">{{ $t('groups.memberLimitInteractionsModal.admin') }}</span>
					</p>
					<p class="text-muted mb-0">{{ $t('groups.memberLimitInteractionsModal.memberSince', { date: formatDate(profile.joined) }) }}</p>
				</div>
			</div>

			<div class="w-100 bg-light mb-1 font-weight-bold d-flex justify-content-center align-items-center border rounded" style="min-height:240px;">
				<div v-if="limitsLoaded" class="py-3">
					<p class="lead mb-0">{{ $t('groups.memberLimitInteractionsModal.interactionPermissions') }}</p>
					<p class="small text-muted">{{ $t('groups.memberLimitInteractionsModal.lastUpdated', { date: updated ? formatDate(updated) : $t('groups.memberLimitInteractionsModal.never') }) }}</p>

					<div class="form-check">
						<input class="form-check-input" type="checkbox" v-model="limits.can_post" :disabled="savingChanges">
						<label class="form-check-label">
							{{ $t('groups.memberLimitInteractionsModal.canPost') }}
						</label>
					</div>

					<div class="form-check">
						<input class="form-check-input" type="checkbox" v-model="limits.can_comment" :disabled="savingChanges">
						<label class="form-check-label">
							{{ $t('groups.memberLimitInteractionsModal.canComment') }}
						</label>
					</div>

					<div class="form-check">
						<input class="form-check-input" type="checkbox" v-model="limits.can_like" :disabled="savingChanges">
						<label class="form-check-label">
							{{ $t('groups.memberLimitInteractionsModal.canLike') }}
						</label>
					</div>

					<hr>

					<button class="btn btn-primary font-weight-bold float-right" @click.prevent="saveChanges" :disabled="savingChanges" style="width:130px;">
						<b-spinner v-if="savingChanges" variant="light" small />
						<span v-else>{{ $t('groups.memberLimitInteractionsModal.saveChanges') }}</span>
					</button>
				</div>
				<div v-else class="d-flex align-items-center flex-column">
					 <b-spinner variant="muted"  />
					 <p class="pt-3 small text-muted font-weight-bold">{{ $t('groups.memberLimitInteractionsModal.loading') }}</p>
				</div>
			</div>
		</b-modal>
	</div>
</template>

<script type="text/javascript">
	export default {
		props: {
			group: {
				type: Object
			},
			profile: {
				type: Object
			}
		},

		data() {
			return {
				limitsLoaded: false,
				limits: {
					can_post: true,
					can_comment: true,
					can_like: true
				},
				updated: null,
				savingChanges: false
			}
		},

		methods: {
			fetchInteractionLimits() {
				axios.get(`/api/v0/groups/${this.group.id}/members/interaction-limits`, {
					params: {
						profile_id: this.profile.id
					}
				})
				.then(res => {
					this.limits = res.data.limits;
					this.updated = res.data.updated_at;
					this.limitsLoaded = true;
				}).catch(err => {
					this.$refs.home.hide();
					swal(this.$t('common.oops'), this.$t('groups.memberLimitInteractionsModal.fetchError'), 'error');
				})
			},

			open(profile) {
				this.loaded = true;
				this.$refs.home.show();
				this.fetchInteractionLimits();
			},

			formatDate(ts) {
				return new Date(ts).toDateString();
			},

			saveChanges() {
				event.currentTarget.blur();
				this.savingChanges = true;

				axios.post(`/api/v0/groups/${this.group.id}/members/interaction-limits`, {
					profile_id: this.profile.id,
					can_post: this.limits.can_post,
					can_comment: this.limits.can_comment,
					can_like: this.limits.can_like,
				})
				.then(res => {
					this.savingChanges = false;
					this.$refs.home.hide();

					this.$bvToast.toast(this.$t('groups.memberLimitInteractionsModal.updated', { username: this.profile.username }), {
						title: this.$t('common.success'),
						variant: 'success',
						autoHideDelay: 5000
					});
				}).catch(err => {
					this.savingChanges = false;
					this.$refs.home.hide();

					if(err.response.status == 422 && err.response.data.error == 'limit_reached') {
							swal(this.$t('groups.memberLimitInteractionsModal.limitReached'), this.$t('groups.memberLimitInteractionsModal.limitReachedMessage'), 'info');
							// swal({
							// 	title: 'Limit Reached',
							// 	text: 'You cannot add any more member limitations',
							// 	icon: 'info',
							// 	buttons: {
							// 		info: {
							// 			className: 'btn-light border',
							// 			text: 'More info',
							// 			value: 'more-info'
							// 		},

							// 		ok: {
							// 			text: 'Ok',
							// 			value: null
							// 		},
							// 	}
							// }).then(value => {
							// 	if(value == 'more-info') {
							// 		location.href = '/site/kb/groups/interaction-limits';
							// 	}
							// });
					} else {
						swal(this.$t('common.oops'), this.$t('groups.memberLimitInteractionsModal.saveError'), 'error');
					}
				});
			}
		}
	}
</script>
