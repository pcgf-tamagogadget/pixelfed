<template>
	<div class="group-invite-component">
		<div class="container">
			<div class="row justify-content-center mt-5">
				<div class="col-12 col-md-7">
					<div class="card shadow-none border" style="min-height: 300px;">
						<div class="card-body d-flex justify-content-center align-items-center">

						<transition-group name="fade">
							<div v-if="tab === 'initial'" key="initial">
								<p class="text-center mb-1"><b-spinner variant="lighter" /></p>
								<p class="text-center small text-muted mb-0">{{ loadingStatus }}</p>
							</div>

							<div v-else-if="tab === 'loading'" key="loading">
								<p class="text-center mb-1"><b-spinner variant="lighter" /></p>
							</div>

							<div v-else-if="tab === 'login'" key="login">
								<i18n path="groups.groupInvite.loginToContinue" tag="p" class="text-center mb-0"><template v-slot:login><a href="/login">{{ $t('groups.groupInvite.login') }}</a></template></i18n>
							</div>

							<div v-else-if="tab === 'form'" key="form">
								<div class="d-flex justify-content-center align-items-center flex-column">
									<i18n path="groups.groupInvite.invitedYou" tag="p" class="text-center h4 font-weight-bold"><template v-slot:user><a href="#">@dansup</a></template></i18n>

									<div class="card my-3 shadow-none border" style="width: 300px;">
										<img v-if="group.metadata && group.metadata.hasOwnProperty('header')" :src="group.metadata.header.url" class="card-img-top" style="width: 100%; height: 100px;object-fit: cover;">
										<div v-else class="card-img-top" style="width: 100px; height: 100px;padding: 5px;">
											<div class="bg-primary d-flex align-items-center justify-content-center" style="width: 100%; height:100%;">
												<i class="fal fa-users text-white fa-lg"></i>
											</div>
										</div>

										<div class="card-body">
											<p class="h5 font-weight-bold mb-1 text-dark">
												{{ group.name || $t('groups.groupInvite.untitledGroup') }}
											</p>

											<transition name="fade">
												<p v-if="showMore" class="text-muted small mb-1">
													{{ group.description }}
												</p>
											</transition>

											<p class="mb-1">
												<span class="text-muted mr-2">
													<i class="far fa-users fa-sm text-lighter mr-1"></i>
													<span class="small font-weight-bold">{{ $t('groups.groupInvite.memberCount', { count: prettyCount(group.member_count) }) }}</span>
												</span>

												<span v-if="!group.local" class="remote-label ml-2">
													<i class="fal fa-globe"></i> {{ $t('groups.groupInvite.remote') }}
												</span>
											</p>

											<transition name="fade">
												<div v-if="showMore">
													<p class="text-muted small mb-1">
														<i class="far fa-tag fa-sm text-lighter mr-2"></i>
														<span class="font-weight-bold">{{ $t('groups.groupInvite.category', { name: group.category.name }) }}</span>
													</p>
													<p class="text-muted small mb-1">
														<i class="far fa-clock fa-sm text-lighter mr-2"></i>
														<span class="font-weight-bold">{{ $t('groups.groupInvite.createdAgo', { time: timeago(group.created_at) }) }}</span>
													</p>
												</div>
											</transition>
										</div>
									</div>

								</div>
								<div class="d-flex justify-content-between">
									<button class="btn btn-light border-lighter font-weight-bold btn-sm" @click="showMoreInfo">
										{{ showMore ? $t('groups.groupInvite.lessInfo') : $t('groups.groupInvite.moreInfo') }}
									</button>
									<div>
										<button class="btn btn-light font-weight-bold btn-sm" @click="declineInvite">{{ $t('groups.groupInvite.decline') }}</button>
										<button class="btn btn-primary font-weight-bold btn-sm" @click="acceptInvite">{{ $t('groups.groupInvite.accept') }}</button>
									</div>
								</div>
								<!-- <p class="text-center h4 font-weight-bold">by <a href="#" class="font-weight-bold">@dansup</a></p> -->
							</div>

							<div v-else-if="tab === 'existingmember'" key="existingmember">
								<p class="text-center mb-0">{{ $t('groups.groupInvite.alreadyMember') }}</p>
								<p class="text-center mb-0">
									<a :href="group.url" class="font-weight-bold">{{ $t('groups.groupInvite.viewGroup') }}</a>
								</p>
							</div>

							<div v-else-if="tab === 'notinvited'" key="notinvited">
								<p class="text-center mb-0">{{ $t('groups.groupInvite.noInvitation') }}</p>
							</div>

							<div v-else-if="tab === 'error'" key="error">
								<p class="text-center mb-0">{{ $t('groups.groupInvite.unknownError') }}</p>
							</div>

							<div v-else key="unknown">
								<p class="text-center mb-0">{{ $t('groups.groupInvite.unknownError') }}</p>
							</div>

						</transition-group>
						</div>
					</div>
					<!-- <h4>You've been invited to {{ group.name }}</h4> -->
				</div>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default {
		props: [
			'id'
		],

		data() {
			return {
				loadingStatus: this.$t('groups.groupInvite.determiningEligibility'),
				tab: 'initial',
				profile: {},
				group: {},
				showMore: false
			}
		},

		mounted() {
			axios.get('/api/pixelfed/v1/accounts/verify_credentials')
			.then(res => {
				this.profile = res.data;
				this.fetchGroup();
			}).catch(err => {
				if(err.response.status === 403) {
					this.tab = 'login';
					return;
				} else {
					this.tab = 'error';
					return
				}
			});
		},

		methods: {
			fetchGroup() {
				axios.get(`/api/v0/groups/${this.id}`)
				.then(res => {
					this.group = res.data;
					this.loadingStatus = this.$t('groups.groupInvite.checkingInvitations');
					this.checkForInvitation();
				}).catch(err => {
					this.tab = 'error';
				});
			},

			checkForInvitation() {
				axios.post(`/api/v0/groups/${this.group.id}/invite/check`)
				.then(res => {
					this.tab = res.data.can_join == true ? 'form' : 'notinvited';
				}).catch(err => {
					if(err.response.status === 422 && err.response.data.error === 'Already a member') {
						this.tab = 'existingmember';
					} else {
						this.tab = 'error';
					}
				})
			},

			prettyCount(val) {
				return App.util.format.count(val);
			},

			timeago(ts) {
				return App.util.format.timeAgo(ts);
			},

			showMoreInfo() {
				event.currentTarget.blur();
				this.showMore = !this.showMore;
			},

			acceptInvite() {
				event.currentTarget.blur();
				this.tab = 'loading';
				axios.post(`/api/v0/groups/${this.group.id}/invite/accept`)
				.then(res => {
					setTimeout(() => {
						location.href = res.data.next_url;
					}, 2000);
				}).catch(err => {
					this.tab = 'error';
				});
			},

			declineInvite() {
				event.currentTarget.blur();
				this.tab = 'loading';
				axios.post(`/api/v0/groups/${this.group.id}/invite/decline`)
				.then(res => {
					location.href = res.data.next_url;
				}).catch(err => {
					this.tab = 'error';
				});
			},
		}
	}
</script>

<style lang="scss">
	.group-invite-component {
		.btn-light {
			border-color: #E5E7EB;
		}
	}
</style>
