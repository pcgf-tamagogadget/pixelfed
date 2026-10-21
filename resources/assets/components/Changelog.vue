<template>
	<div class="web-wrapper">
		<div class="container-fluid mt-3">
			<div class="row">
				<div class="col-md-3 d-md-block">
					<sidebar :user="profile" />
				</div>

				<div class="col-md-6">
					<div class="jumbotron shadow-sm bg-white">
						<div class="text-center">
							<h1 class="font-weight-bold">{{ $t('spa.changelog.title') }}</h1>
							<p class="lead mb-0">{{ $t('spa.changelog.subtitle', { name: 'Metro 2.0' }) }}</p>
						</div>
					</div>

					<div class="mt-4 pb-3">
						<p class="lead">{{ $t('spa.changelog.apr2022.date') }}</p>
						<ul>
							<li class="font-weight-bold">
								{{ $t('spa.changelog.apr2022.darkMode') }} <br />
								<p class="small">{{ $t('spa.changelog.apr2022.darkModeHelp') }}</p>
							</li>
							<li>{{ $t('spa.changelog.apr2022.i18n', { count: 7 }) }}</li>
						</ul>
					</div>

					<div class="mt-4 pb-3">
						<p class="lead">{{ $t('spa.changelog.mar2022.date') }}</p>
						<ul>
							<li class="font-weight-bold">{{ $t('spa.changelog.mar2022.fullScreenPreviews') }}</li>
							<li class="font-weight-bold">{{ $t('spa.changelog.mar2022.filterNotifications') }}</li>
							<li>{{ $t('spa.changelog.mar2022.sharedByLink') }}</li>
							<li>{{ $t('spa.changelog.mar2022.privateFeedFix') }}</li>
						</ul>
					</div>

					<div class="mt-4 pb-3">
						<p class="lead">{{ $t('spa.changelog.feb2022.date') }}</p>
						<ul>
							<li class="font-weight-bold">{{ $t('spa.changelog.feb2022.discoverLayout') }}</li>
							<li class="font-weight-bold">{{ $t('spa.changelog.feb2022.drawerMenu') }}</li>
							<li class="font-weight-bold">{{ $t('spa.changelog.feb2022.profileLayoutSetting') }}</li>
							<li>{{ $t('spa.changelog.feb2022.mobileSearch') }}</li>
							<li>{{ $t('spa.changelog.feb2022.mobileProfileLayout') }}</li>
							<li class="font-weight-bold">{{ $t('spa.changelog.feb2022.threadedComments') }}</li>
							<li>{{ $t('spa.changelog.feb2022.mediaPreviewDefault') }}</li>
							<li>{{ $t('spa.changelog.feb2022.locationSearch') }}</li>
							<li>{{ $t('spa.changelog.feb2022.commentButton') }}</li>
							<li>{{ $t('spa.changelog.feb2022.avatarFix') }}</li>
							<li>{{ $t('spa.changelog.feb2022.remoteHashtags') }}</li>
							<li>{{ $t('spa.changelog.feb2022.mediaLicense') }}</li>
							<li class="font-weight-bold">{{ $t('spa.changelog.feb2022.mediaPreviews') }}</li>
							<li class="font-weight-bold">{{ $t('spa.changelog.feb2022.commentHovercards') }}</li>
							<li class="font-weight-bold"><i18n path="spa.changelog.feb2022.quickAvatar" tag="span"><template v-slot:icon><i class="far fa-cog"></i></template></i18n></li>
							<li class="font-weight-bold">{{ $t('spa.changelog.feb2022.followsYouBadge') }}</li>
							<li>{{ $t('spa.changelog.feb2022.hideCounts') }}</li>
							<li>{{ $t('spa.changelog.feb2022.nsfwVideoFix') }}</li>
							<li>{{ $t('spa.changelog.feb2022.modTools') }}</li>
						</ul>
					</div>

					<div class="mt-4 pb-3">
						<p class="lead">{{ $t('spa.changelog.jan2022.date') }}</p>
						<ul>
							<li>{{ $t('spa.changelog.jan2022.commentDeletion') }}</li>
							<li class="font-weight-bold">{{ $t('spa.changelog.jan2022.reactionBar') }}</li>
							<li class="font-weight-bold">{{ $t('spa.changelog.jan2022.fresherComments') }}</li>
							<li>{{ $t('spa.changelog.jan2022.commentAutoload') }}</li>
							<li>{{ $t('spa.changelog.jan2022.likesFeed') }}</li>
							<li>{{ $t('spa.changelog.jan2022.emojiFix') }}</li>
							<li>{{ $t('spa.changelog.jan2022.duplicateNotifications') }}</li>
							<li>{{ $t('spa.changelog.jan2022.onboardingFeed') }}</li>
							<li>{{ $t('spa.changelog.jan2022.pronouns') }}</li>
							<li>{{ $t('spa.changelog.jan2022.emojiTimelineFix') }}</li>
							<li class="font-weight-bold">{{ $t('spa.changelog.jan2022.hovercards') }}</li>
							<li class="font-weight-bold">{{ $t('spa.changelog.jan2022.searchBar') }}</li>
							<li>{{ $t('spa.changelog.jan2022.fullUsernames') }}</li>
							<li>{{ $t('spa.changelog.jan2022.discoverDefault') }}</li>
							<li>{{ $t('spa.changelog.jan2022.hashtagFeed') }}</li>
							<li class="font-weight-bold">{{ $t('spa.changelog.jan2022.reportModal') }}</li>
							<li><i18n path="spa.changelog.jan2022.profileFeedFix" tag="span"><template v-slot:icon><i class="far fa-bars px-1"></i></template></i18n></li>
							<li>{{ $t('spa.changelog.jan2022.profileMobileLayout') }}</li>
						</ul>
					</div>

					<div class="pb-3">
						<p class="lead">{{ $t('spa.changelog.older') }}</p>
						<i18n path="spa.changelog.olderText" tag="p"><template v-slot:link><a href="https://raw.githubusercontent.com/pixelfed/pixelfed/dev/CHANGELOG.md">{{ $t('spa.changelog.here') }}</a></template></i18n>
					</div>
				</div>

				<div class="col-md-3">
					<div class="alert alert-primary">
						<p class="mb-0 small">{{ $t('spa.changelog.feedbackNotice') }}</p>
					</div>
				</div>
			</div>
		</div>
		<drawer />
	</div>
</template>

<script type="text/javascript">
	import Drawer from './partials/drawer.vue';
	import Sidebar from './partials/sidebar.vue';

	export default {
		components: {
			"drawer": Drawer,
			"sidebar": Sidebar,
		},

		data() {
			return {
				isLoaded: false,
				profile: undefined,
				instance: undefined,
				nodeinfo: undefined,
				config: window.App.config
			}
		},

		mounted() {
			this.profile = window._sharedData.user;
		}
	}
</script>
