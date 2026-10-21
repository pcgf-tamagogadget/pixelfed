<template>
	<div class="discover-admin-settings-component">
		<div v-if="isLoaded" class="container-fluid mt-3">

			<div class="row">
				<div class="col-md-4 col-lg-3">
					<sidebar :user="profile" />
				</div>

				<div class="col-md-6 col-lg-6">
					<b-breadcrumb class="font-default" :items="breadcrumbItems"></b-breadcrumb>

					<h1 class="font-default">{{ $t('spa.discoverSettings.title') }}</h1>
					<!-- <p class="font-default lead">Browse timelines of a specific instance</p> -->

					<hr>

					<div class="card font-default shadow-none border">
						<div class="card-header">
							<p class="text-center font-weight-bold mb-0">{{ $t('spa.discoverSettings.manageFeatures') }}</p>
						</div>
						<div class="card-body">

							<div class="mb-2">
								<b-form-checkbox size="lg" v-model="hashtags.enabled" name="check-button" switch class="font-weight-bold">
									{{ $t('spa.discoverHashtags.title') }}
								</b-form-checkbox>
								<p class="text-muted">{{ $t('spa.discoverSettings.hashtagsHelp') }}</p>
							</div>

							<div class="mb-2">
								<b-form-checkbox size="lg" v-model="memories.enabled" name="check-button" switch class="font-weight-bold">
									{{ $t('spa.discoverMemories.title') }}
								</b-form-checkbox>
								<p class="text-muted">{{ $t('spa.discoverSettings.memoriesHelp') }}</p>
							</div>

							<div class="mb-2">
								<b-form-checkbox size="lg" v-model="insights.enabled" name="check-button" switch class="font-weight-bold">
									{{ $t('spa.discoverInsights.title') }}
								</b-form-checkbox>
								<p class="text-muted">{{ $t('spa.discoverSettings.insightsHelp') }}</p>
							</div>

							<div class="mb-2">
								<b-form-checkbox size="lg" v-model="friends.enabled" name="check-button" switch class="font-weight-bold">
									{{ $t('spa.discoverFindFriends.title') }}
								</b-form-checkbox>
								<p class="text-muted">{{ $t('spa.discoverSettings.friendsHelp') }}</p>
							</div>

							<div>
								<b-form-checkbox size="lg" v-model="server.enabled" name="check-button" switch class="font-weight-bold">
									{{ $t('spa.discoverServerFeed.title') }}
								</b-form-checkbox>
								<p class="text-muted">{{ $t('spa.discoverSettings.serverHelp') }}</p>
							</div>
						</div>
					</div>

					<div v-if="server.enabled" class="card font-default shadow-none border my-3">
						<div class="card-header">
							<p class="text-center font-weight-bold mb-0">{{ $t('spa.discoverSettings.manageServerTimelines') }}</p>
						</div>
						<div class="card-body">
							<div class="mb-2">
								<b-form-group :label="$t('spa.discoverSettings.serverMode')">
									<b-form-radio v-model="server.mode" value="all" disabled>{{ $t('spa.discoverSettings.allowAny') }}</b-form-radio>
									<b-form-radio v-model="server.mode" value="allowlist">{{ $t('spa.discoverSettings.limitByDomains') }}</b-form-radio>
								</b-form-group>
								<p class="text-muted">{{ $t('spa.discoverSettings.serverModeHelp') }}</p>
							</div>

							<div v-if="server.mode == 'allowlist'">
								<b-form-group :label="$t('spa.discoverSettings.allowedDomains')">
									<b-form-textarea
										v-model="server.domains"
										:placeholder="$t('spa.discoverSettings.allowedDomainsPlaceholder')"
										rows="3"
										max-rows="6"
									></b-form-textarea>
								</b-form-group>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-2 col-lg-3">
					<button v-if="hasChanged" class="btn btn-primary btn-block primary font-weight-bold" @click="saveFeatures">{{ $t('spa.discoverSettings.saveChanges') }}</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
import Drawer from './../partials/drawer.vue';
import Sidebar from './../partials/sidebar.vue';
import StatusCard from './../partials/TimelineStatus.vue';

export default {
	components: {
		"drawer": Drawer,
		"sidebar": Sidebar,
		"status-card": StatusCard
	},

	data() {
		return {
			isLoaded: false,
			isLoading: true,
			profile: window._sharedData.user,
			breadcrumbItems: [
				{
					text: this.$t('navmenu.discover'),
					href: '/i/web/discover'
				},
				{
					text: this.$t('navmenu.settings'),
					active: true
				}
			],
			hasChanged: false,
			features: {},
			original: undefined,
			hashtags: { enabled: undefined },
			memories: { enabled: undefined },
			insights: { enabled: undefined },
			friends: { enabled: undefined },
			server: { enabled: undefined, mode: 'allowlist', domains: '' },
		}
	},

	watch: {
		hashtags: {
			deep: true,
			handler: function(val, old) {
				this.updateFeatures('hashtags');
			},
		},

		memories: {
			deep: true,
			handler: function(val, old) {
				this.updateFeatures('memories');
			},
		},

		insights: {
			deep: true,
			handler: function(val, old) {
				this.updateFeatures('insights');
			},
		},

		friends: {
			deep: true,
			handler: function(val, old) {
				this.updateFeatures('friends');
			},
		},

		server: {
			deep: true,
			handler: function(val, old) {
				this.updateFeatures('server');
			},
		}
	},

	beforeMount() {
		if(!this.profile.is_admin) {
			this.$router.push('/i/web/discover');
		}
		this.fetchConfig();
	},

	methods: {
		fetchConfig() {
			axios.get('/api/pixelfed/v2/discover/meta')
			.then(res => {
				this.original = res.data;
				this.storeOriginal(res.data);
			})
		},

		storeOriginal(data) {
			this.friends.enabled = data.friends.enabled;
			this.hashtags.enabled = data.hashtags.enabled;
			this.insights.enabled = data.insights.enabled;
			this.memories.enabled = data.memories.enabled;
			this.server = {
				domains: data.server.domains,
				enabled: data.server.enabled,
				mode: data.server.mode
			};
			this.isLoaded = true;
		},

		updateFeatures(id) {
			if(!this.isLoaded) {
				return;
			}
			let changed = false;
			if(this.friends.enabled !== this.original.friends.enabled) {
				changed = true;
			}
			if(this.hashtags.enabled !== this.original.hashtags.enabled) {
				changed = true;
			}
			if(this.insights.enabled !== this.original.insights.enabled) {
				changed = true;
			}
			if(this.memories.enabled !== this.original.memories.enabled) {
				changed = true;
			}
			if(this.server.enabled !== this.original.server.enabled) {
				changed = true;
			}
			if(this.server.domains !== this.original.server.domains) {
				changed = true;
			}
			if(this.server.mode !== this.original.server.mode) {
				changed = true;
			}
			// if(JSON.stringify(this.server) !== JSON.stringify(this.original.server)) {
			// 	changed = true;
			// }
			this.hasChanged = changed;
		},

		saveFeatures() {
			axios.post('/api/pixelfed/v2/discover/admin/features', {
				features: {
					friends: this.friends,
					hashtags: this.hashtags,
					insights: this.insights,
					memories: this.memories,
					server: this.server
				}
			})
			.then(res => {
				// let data = {
				// 	friends: res.data.friends,
				// 	hashtags: res.data.hashtags,
				// 	insights: res.data.insights,
				// 	memories: res.data.memories,
				// 	server: res.data.server
				// }
				// this.original = data;
				this.server = res.data.server;
				this.$bvToast.toast(this.$t('spa.discoverSettings.updated'), {
					title: this.$t('spa.discoverSettings.title'),
					autoHideDelay: 5000,
					appendToast: true,
					variant: 'success'
				})
			})
		}
	}
}
</script>

<style lang="scss" scoped>
	.discover-admin-settings-component {
		.bg-stellar {
			background: #7474BF;
			background: -webkit-linear-gradient(to right, #348AC7, #7474BF);
			background: linear-gradient(to right, #348AC7, #7474BF);
		}
		.font-default {
			font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
			letter-spacing: -0.7px;
		}

		.active {
			font-weight: 700;
		}
	}
</style>
