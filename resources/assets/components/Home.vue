<template>
    <div class="web-wrapper">
        <div v-if="isLoaded" class="container-fluid mt-3">
            <div class="row">
                <div class="col-md-4 col-lg-3">
                    <sidebar
                        :user="profile"
                        @refresh="shouldRefresh = true" />
                </div>

                <div class="col-md-8 col-lg-6 px-0">
                    <template v-if="showUpdateWarning && updateInfo && updateInfo.hasOwnProperty('running_latest')">
                        <div class="card rounded-lg mb-4 ft-std" style="background: #e11d48;border: 3px dashed #fff">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center flex-column flex-lg-row" style="gap:1rem">
                                    <div class="d-flex justify-content-between align-items-center" style="gap:1rem">
                                        <i class="d-none d-sm-block far fa-exclamation-triangle fa-5x text-white"></i>

                                        <div>
                                            <h1 class="h3 font-weight-bold text-light mb-0">{{ $t('spa.home.newUpdateAvailable') }}</h1>
                                            <p class="mb-0 text-white" style="font-size:18px;">{{ $t('spa.home.updateAsap') }}</p>
                                            <p class="mb-n1 text-white small" style="opacity:.7">{{ $t('spa.home.onceYouUpdate') }}</p>
                                            <p class="mb-0 text-white small d-flex" style="opacity:.5;gap:1rem;">
                                                <span>{{ $t('spa.home.currentVersion') }} <strong>{{ updateInfo?.current ?? $t('spa.home.unknown') }}</strong></span>
                                                <span>{{ $t('spa.home.latestVersion') }} <strong>{{ updateInfo?.latest?.version ?? $t('spa.home.unknown') }}</strong></span>
                                            </p>
                                        </div>
                                    </div>

                                    <a v-if="updateInfo.latest.url" class="btn btn-light font-weight-bold" :href="updateInfo.latest.url" target="_blank">{{ $t('spa.home.viewUpdate') }}</a>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-if="showUpdateConnectionWarning">
                        <div class="card rounded-lg mb-4 ft-std" style="background: #e11d48;border: 3px dashed #fff">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center flex-column flex-lg-row" style="gap:1rem">
                                    <div class="d-flex justify-content-between align-items-center" style="gap:1rem">
                                        <i class="d-none d-sm-block far fa-exclamation-triangle fa-5x text-white"></i>

                                        <div>
                                            <h1 class="h3 font-weight-bold text-light mb-1">{{ $t('spa.home.updateCheckFailed') }}</h1>
                                            <i18n path="spa.home.updateCheckFailedMessage" tag="p" class="mb-1 text-white" style="font-size:18px;line-height: 1.2;"><template v-slot:link><a href="https://github.com/pixelfed/pixelfed/releases" class="text-white font-weight-bold" style="text-decoration: underline;" target="_blank">{{ $t('spa.home.clickHere') }}</a></template></i18n>
                                            <i18n path="spa.home.disableWarningHint" tag="p" class="mb-0 text-white small"><template v-slot:setting><code class="text-white">INSTANCE_SOFTWARE_UPDATE_DISABLE_FAILED_WARNING=true</code></template></i18n>
                                            <p class="mb-0 text-white small" style="opacity:.7">{{ $t('spa.home.currentVersion') }} {{ updateInfo?.current ?? $t('spa.home.unknown') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <story-carousel
                        v-if="storiesEnabled"
                        :profile="profile" />

                    <timeline
                        :profile="profile"
                        :scope="scope"
                        :key="scope"
                        v-on:update-profile="updateProfile"
                        :refresh="shouldRefresh"
                        @refreshed="shouldRefresh = false" />
                </div>

                <div class="d-none d-lg-block col-lg-3">
                    <rightbar class="sticky-top sidebar" />
                </div>
            </div>

            <drawer />
        </div>

        <div v-else class="d-flex justify-content-center align-items-center" style="height:calc(100vh - 58px);">
            <b-spinner />
        </div>
    </div>
</template>

<script type="text/javascript">
    import Drawer from './partials/drawer.vue';
    import Sidebar from './partials/sidebar.vue';
    import Rightbar from './partials/rightbar.vue';
    import Timeline from './sections/Timeline.vue';
    import Notifications from './sections/Notifications.vue';
    import StoryCarousel from './partials/timeline/StoryCarousel.vue';

    export default {
        props: {
            scope: {
                type: String,
                default: 'home'
            }
        },

        components: {
            "drawer": Drawer,
            "sidebar": Sidebar,
            "timeline": Timeline,
            "rightbar": Rightbar,
            "story-carousel": StoryCarousel,
        },
        data() {
            return {
                isLoaded: false,
                profile: undefined,
                recommended: [],
                trending: [],
                storiesEnabled: false,
                shouldRefresh: false,
                showUpdateWarning: false,
                showUpdateConnectionWarning: false,
                updateInfo: undefined,
            }
        },

        mounted() {
            this.init();
        },

        watch: {
            '$route': 'init'
        },

        methods: {
            init() {
                this.profile = window._sharedData.user;
                this.isLoaded = true;
                this.storiesEnabled = window.App?.config?.features?.hasOwnProperty('stories') ? window.App.config.features.stories : false;

                if(this.profile.is_admin) {
                    this.softwareUpdateCheck();
                }
            },

            updateProfile(delta) {
                this.profile = Object.assign(this.profile, delta);
            },

            softwareUpdateCheck() {
                axios.get('/api/web-admin/software-update/check')
                .then(res => {
                    if(!res || !res.data || !res.data.hasOwnProperty('running_latest') || res.data.running_latest) {
                        return;
                    }
                    if(res.data.running_latest === null) {
                        this.updateInfo = res.data;
                        this.showUpdateConnectionWarning = true;
                        return;
                    }
                    this.updateInfo = res.data;
                    this.showUpdateWarning = !res.data.running_latest;
                })
                .catch(err => {
                    this.showUpdateConnectionWarning = true;
                })
            }
        }
    }
</script>

<style lang="scss" scoped>
    .avatar {
        border-radius: 15px;
    }

    .username {
        margin-bottom: -6px;
    }

    .btn-white {
        background-color: #fff;
        border: 1px solid #F3F4F6;
    }

    .sidebar {
        top: 90px;
    }
</style>
