<template>
	<div class="group-topic-feed-component">
		<div v-if="isLoaded" class="bg-white py-5 border-bottom">
			<div class="container">
				<div class="d-flex justify-content-between align-items-center">
					<div>
						<h3 class="font-weight-bold mb-1">#{{ name }}</h3>
						<p class="mb-0 lead text-muted">
							<span>
								<i18n path="groups.groupTopicFeed.postsIn" tag="span"><template v-slot:group><a :href="group.url" class="text-muted font-weight-bold">{{ group.name }}</a></template></i18n>
							</span>
							<span>·</span>
							<span><i class="fas fa-globe"></i></span>
							<span>·</span>
							<span>{{ group.membership != 'all' ? $t('groups.groupTopicFeed.privateGroup') : $t('groups.groupTopicFeed.publicGroup') }}</span>
						</p>
					</div>
					<!-- <div>
						<button class="btn btn-light border btn-lg text-muted">
							<i class="fas fa-ellipsis-h"></i>
						</button>
					</div> -->
				</div>
			</div>
		</div>
		<div v-if="isLoaded" class="row justify-content-center mt-3">
			<div v-if="feed.length" class="col-12 col-md-5">
				<group-status
					v-for="(status, index) in feed"
					:key="'gs:' + status.id + index"
					:prestatus="status"
					:profile="profile"
					:group="group"
					:show-group-chevron="true"
					:group-id="gid" />

				<div v-if="feed.length > 2">
					<infinite-loading @infinite="infiniteFeed">
						<div slot="no-more"></div>
						<div slot="no-results"></div>
					</infinite-loading>
				</div>
			</div>
			<div v-else class="col-12 col-md-5 d-flex justify-content-center">
				<div class="mt-5">
					<p class="text-lighter text-center">
						<i class="fal fa-exclamation-circle fa-4x"></i>
					</p>

					<i18n path="groups.groupTopicFeed.cannotLoad" tag="p" class="font-weight-bold text-muted"><template v-slot:hashtag><span class="font-weight-normal">#{{ name }}</span></template></i18n>

					<p class="text-left">
						{{ $t('groups.groupTopicFeed.reasons') }}
					</p>

					<ul class="text-left">
						<li>{{ $t('groups.groupTopicFeed.reasonTypo') }}</li>
						<li>{{ $t('groups.groupTopicFeed.reasonNoPosts') }}</li>
						<li>{{ $t('groups.groupTopicFeed.reasonBanned') }}</li>
						<li>{{ $t('groups.groupTopicFeed.reasonNew') }}</li>
						<li>{{ $t('groups.groupTopicFeed.reasonTechnical') }}</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
	import GroupStatus from '@/groups/partials/GroupStatus.vue';

	export default {
		props: {
			gid: {
				type: String
			},

			name: {
				type: String
			}
		},

		components: {
			GroupStatus
		},

		data() {
			return {
				isLoaded: false,
				group: false,
				profile: false,
				feed: [],
				page: 1,
				ids: []
			}
		},

		mounted() {
			this.fetchProfile();
		},

		methods: {
			fetchProfile() {
				axios.get('/api/pixelfed/v1/accounts/verify_credentials')
				.then(res => {
					this.profile = res.data;
					this.fetchGroup();
				});
			},

			fetchGroup() {
				axios.get('/api/v0/groups/' + this.gid)
				.then(res => {
					this.group = res.data;
					this.fetchFeed();
				});
			},

			fetchFeed() {
				axios.get('/api/v0/groups/topics/tag', {
					params: {
						gid: this.gid,
						name: this.name
					}
				}).then(res => {
					this.feed = res.data;
					this.isLoaded = true;
					let self = this;
					res.data.forEach(d => {
						if(self.ids.indexOf(d.id) == -1) {
							self.ids.push(d.id);
						}
					});
					this.page++;
				})
			},

			infiniteFeed($state) {
				if(this.feed.length < 2) {
					$state.complete();
					return;
				}

				axios.get('/api/v0/groups/topics/tag', {
					params: {
						gid: this.gid,
						name: this.name,
						limit: 1,
						page: this.page
					},
				}).then(res => {
					if (res.data.length) {
						let data = res.data;
						let self = this;
						data.forEach(d => {
							if(self.ids.indexOf(d.id) == -1) {
								self.ids.push(d.id);
								self.feed.push(d);
							}
						});
						$state.loaded();
						this.page++;
					} else {
						$state.complete();
					}
				});
			}
		}
	}
</script>
