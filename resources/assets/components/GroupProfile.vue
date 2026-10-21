<template>
    <div class="group-profile-component w-100 h-100">
        <div v-if="!loaded" class="w-100 h-100">
            <div class="d-flex justify-content-center align-items-center mt-5">
                <div class="spinner-border" role="status">
                  <span class="sr-only">{{ $t('common.loading') }}</span>
                </div>
            </div>
        </div>
        <template v-else>
            <div class="bg-white mb-3 border-bottom">
                <div class="container-xl header">
                    <div class="header-jumbotron"></div>

                    <div class="header-profile-card">
                        <img :src="profile.avatar" class="avatar" onerror="this.onerror=null;this.src='/storage/avatars/default.png?v=2'">
                        <p class="name">
                            {{ profile.display_name }}
                        </p>
                        <p class="username text-muted">
                            <span v-if="profile.local">&commat;{{ profile.username }}</span>
                            <span v-else>{{ profile.acct }}</span>

                            <span v-if="profile.is_admin" class="text-danger ml-1" :title="$t('groups.groupProfilePage.siteAdministrator')" data-toggle="tooltip" data-placement="bottom"><i class="far fa-users-crown"></i></span>
                        </p>
                    </div>
                    <!-- <hr> -->
                    <div class="header-navbar">
                        <div></div>

                        <div>
                            <a
                                v-if="currentProfile.id === profile.id"
                                class="btn btn-light font-weight-bold mr-2"
                                href="/settings/home">
                                <i class="fas fa-edit mr-1"></i> {{ $t('groups.groupProfilePage.editProfile') }}
                            </a>

                            <a
                                v-if="relationship.following"
                                class="btn btn-primary font-weight-bold mr-2"
                                :href="profile.url">
                                <i class="far fa-comment-alt-dots mr-1"></i> {{ $t('groups.groupProfilePage.message') }}
                            </a>

                            <a
                                v-if="relationship.following"
                                class="btn btn-light font-weight-bold mr-2"
                                :href="profile.url">
                                <i class="fas fa-user-check mr-1"></i> {{ relationship.followed_by ? $t('groups.groupProfilePage.friends') : $t('groups.groupProfilePage.following') }}
                            </a>

                            <a
                                v-if="!relationship.following"
                                class="btn btn-light font-weight-bold mr-2"
                                :href="profile.url">
                                <i class="fas fa-user mr-1"></i> {{ $t('groups.groupProfilePage.viewMainProfile') }}
                            </a>

                            <div class="dropdown">
                                <button class="btn btn-light font-weight-bold dropdown-toggle" type="button" id="amenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="amenu">
                                    <a v-if="currentProfile.id != profile.id" class="dropdown-item font-weight-bold" :href="`/i/report?type=user&id=${profile.id}`">{{ $t('groups.groupProfilePage.report') }}</a>
                                    <a v-if="currentProfile.id == profile.id" class="dropdown-item font-weight-bold" href="#">{{ $t('groups.groupProfilePage.leaveGroup') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-100 h-100 group-profile-feed">
                <div class="container-xl">
                    <div class="row">
                        <div class="col-12 col-md-5">
                            <div class="card card-body shadow-sm infolet">
                                <h5 class="font-weight-bold mb-3">{{ $t('groups.groupProfilePage.intro') }}</h5>
                                <div v-if="!profile.local" class="media mb-3 align-items-center">
                                    <div class="media-icon">
                                        <i class="far fa-globe" :title="$t('groups.groupProfilePage.remoteUserTooltip')" data-toggle="tooltip" data-placement="bottom"></i>
                                    </div>
                                    <div class="media-body">
                                        <i18n path="groups.groupProfilePage.remoteMemberFrom" tag="span"><template v-slot:domain><strong>{{ profile.acct.split('@')[1] }}</strong></template></i18n>
                                    </div>
                                </div>
                                <!-- <div v-if="profile.note.length" class="media mb-3 align-items-center">
                                    <i class="far fa-book-user fa-lg text-lighter mr-3" title="User bio" data-toggle="tooltip" data-placement="bottom"></i>
                                    <div class="media-body">
                                        <span v-html="profile.note"></span>
                                    </div>
                                </div> -->
                                <div class="media align-items-center">
                                    <div class="media-icon">
                                        <i class="fas fa-users" :title="$t('groups.groupProfilePage.joinedTooltip')" data-toggle="tooltip" data-placement="bottom"></i>
                                    </div>
                                    <div class="media-body">
                                        <i18n path="groups.groupProfilePage.roleSince" tag="span"><template v-slot:role>{{ roleTitle }}</template><template v-slot:group><strong>{{ group.name }}</strong></template><template v-slot:date>{{ formatJoinedDate(profile.group?.joined) }}</template></i18n>
                                    </div>
                                </div>
                            </div>

                            <div v-if="canIntersect" class="card card-body shadow-sm infolet">
                                <h5 class="font-weight-bold mb-3">{{ $t('groups.groupProfilePage.thingsInCommon') }}</h5>

                                <div v-if="commonIntersects.friends.length" class="media mb-3 align-items-center" v-once>
                                    <div class="media-icon">
                                        <i class="far fa-user-friends"></i>
                                    </div>
                                    <div class="media-body">
                                        {{ commonIntersects.friends.length > 1 ? $t('groups.groupProfilePage.mutualFriendsIncluding', { count: commonIntersects.friends_count }) : $t('groups.groupProfilePage.mutualFriendIncluding', { count: commonIntersects.friends_count }) }}
                                        <span v-for="(friend, index) in commonIntersects.friends"><a :href="friend.url" class="text-dark font-weight-bold">{{ friend.acct }}</a><span v-if="commonIntersects.friends.length > index + 1">, </span><span v-else> </span></span>
                                        <!-- <a href="#" class="text-dark font-weight-bold">dansup</a>, <a href="#" class="text-dark font-weight-bold">admin</a> and 1 other -->
                                    </div>
                                </div>

                                <!-- <div class="media mb-3 align-items-center">
                                    <div class="media-icon">
                                        <i class="fas fa-home"></i>
                                    </div>
                                    <div class="media-body">
                                        Lives in <strong>Canada</strong>
                                    </div>
                                </div> -->

                                <div v-if="commonIntersects.groups.length" class="media mb-3 align-items-center">
                                    <div class="media-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="media-body">
                                        <i18n path="groups.groupProfilePage.alsoMemberOf" tag="span"><template v-slot:group><a :href="commonIntersects.groups[0].url" class="text-dark font-weight-bold">{{ commonIntersects.groups[0].name }}</a></template><template v-slot:count>{{ commonIntersects.groups_count }}</template></i18n>
                                    </div>
                                </div>

                                <div v-if="commonIntersects.topics.length" class="media mb-0 align-items-center">
                                    <div class="media-icon">
                                        <i class="far fa-thumbs-up fa-lg text-lighter"></i>
                                    </div>
                                    <div class="media-body">
                                        <i18n path="groups.groupProfilePage.alsoInterestedIn" tag="span"><template v-slot:topics><span v-for="(topic, index) in commonIntersects.topics">
                                            <span v-if="commonIntersects.topics.length - 1 == index"> {{ $t('groups.groupProfilePage.and') }} </span><a :href="topic.url" class="font-weight-bold text-dark">#{{ topic.name }}</a><span v-if="commonIntersects.topics.length > index + 2">, </span>
                                        </span></template></i18n>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-7">
                            <div class="card card-body shadow-sm">
                                <h5 class="font-weight-bold mb-0">{{ $t('groups.groupProfilePage.groupPosts') }}</h5>
                            </div>

                            <div v-if="feedEmpty" class="pt-5 text-center">
                                <h5>{{ $t('groups.groupProfilePage.noNewPosts') }}</h5>
                                <i18n path="groups.groupProfilePage.noPostsYet" tag="p"><template v-slot:username>{{ profile.username }}</template><template v-slot:group><strong>{{ group.name }}</strong></template></i18n>

                                <a :href="group.url" class="font-weight-bold">{{ $t('groups.groupProfilePage.goBack') }}</a>
                            </div>

                            <div v-if="feedLoaded" class="mt-2">
                                <group-status
                                    v-for="(status, index) in feed"
                                    :key="'gps:' + status.id"
                                    :permalinkMode="true"
                                    :showGroupChevron="true"
                                    :group="group"
                                    :prestatus="status"
                                    :profile="profile"
                                    :group-id="group.id" />

                                <div v-if="feed.length >= 1" :distance="800">
                                    <infinite-loading @infinite="infiniteFeed">
                                        <div slot="no-more"></div>
                                        <div slot="no-results"></div>
                                    </infinite-loading>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>

<script type="text/javascript">
    import GroupStatus from '@/groups/partials/GroupStatus.vue';

    export default {
        props: {
            gid: {
                type: String
            },

            pid: {
                type: String
            }
        },

        components: {
            'group-status': GroupStatus
        },

        data() {
            return {
                loaded: false,
                currentProfile: {},
                roleTitle: this.$t('groups.groupProfilePage.member'),
                group: {},
                profile: {},
                relationship: {
                    following: false,
                },
                feed: [],
                ids: [],
                feedLoaded: false,
                feedEmpty: false,
                page: 1,
                canIntersect: false,
                commonIntersects: []
            }
        },

        beforeMount() {
            $('body').css('background-color', '#f0f2f5');
        },

        mounted() {
            this.fetchGroup();
            this.$nextTick(() => {
                $('[data-toggle="tooltip"]').tooltip();
            });
        },

        methods: {
            fetchGroup() {
                axios.get('/api/v0/groups/' + this.gid)
                .then(res => {
                    this.group = res.data;
                })
                .finally(() => {
                    this.fetchSelfProfile();
                })
            },

            fetchSelfProfile() {
                axios.get('/api/pixelfed/v1/accounts/verify_credentials')
                .then(res => {
                    this.currentProfile = res.data;
                })
                .catch(err => {
                    this.$router.push('/groups/' + this.gid)
                })
                .finally(() => {
                    this.fetchProfile();
                })

                this.$nextTick(() => {
                    $('[data-toggle="tooltip"]').tooltip();
                });
            },

            fetchProfile() {
                axios.get('/api/v0/groups/accounts/' + this.gid + '/' + this.pid)
                .then(res => {
                    this.profile = res.data;
                    if(res.data.group.role == 'founder') {
                        this.roleTitle = this.$t('groups.groupProfilePage.admin');
                    }
                })

                if(window._sharedData.user.id == this.pid) {
                    this.fetchInitialFeed();
                    return;
                }

                axios.get('/api/v1/accounts/relationships?id[]=' + this.pid)
                .then(res => {
                    this.relationship = res.data[0];
                })
                .finally(() => {
                    this.fetchInitialFeed();
                })
            },
            fetchInitialFeed() {
                if(window._sharedData.user && window._sharedData.user.id != this.pid) {
                    this.fetchCommonIntersections();
                }
                axios.get(`/api/v0/groups/${this.gid}/user/${this.pid}/feed`)
                .then(res => {
                    this.feed = res.data.filter(s => {
                        return s.pf_type != 'reply:text' || s.account.id != this.profile.id;
                    });
                    this.feedLoaded = true;
                    this.feedEmpty = this.feed.length == 0;
                    this.page++;
                    this.loaded = true;
                })
                .catch(err => {
                    this.$router.push('/groups/' + this.gid);
                    console.log(err)
                });
            },

            infiniteFeed($state) {
                if(this.feed.length == 0) {
                    $state.complete();
                    return;
                }

                axios.get(`/api/v0/groups/${this.group.id}/user/${this.profile.id}/feed`, {
                    params: {
                        page: this.page
                    },
                }).then(res => {
                    if (res.data.length) {
                        let data = res.data.filter(s => {
                            return s.pf_type != 'reply:text' || s.account.id != this.profile.id;
                        });
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
            },

            fetchCommonIntersections() {
                axios.get('/api/v0/groups/member/intersect/common', {
                    params: {
                        gid: this.gid,
                        pid: this.pid
                    }
                }).then(res => {
                    this.commonIntersects = res.data;
                    this.canIntersect = res.data.groups.length || res.data.topics.length;
                });

            },

            formatJoinedDate(ts) {
                let date = new Date(ts);
                let options = { year: 'numeric', month: 'long' };
                let formatter = new Intl.DateTimeFormat((document.documentElement.lang || 'en-US'), options);
                return formatter.format(date);
            }
        }
    }
</script>

<style lang="scss">
    .group-profile-component {
        background-color: #f0f2f5;

        .header {
            &-jumbotron {
                background-color: #F3F4F6;
                height: 320px;
                border-bottom-left-radius: 20px;
                border-bottom-right-radius: 20px;
            }

            &-profile-card {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;

                .avatar {
                    width: 170px;
                    height: 170px;
                    border-radius: 50%;
                    margin-top: -150px;
                    margin-bottom: 20px;
                }

                .name {
                    font-size: 30px;
                    line-height: 30px;
                    font-weight: 700;
                    text-align: center;
                    margin-bottom: 6px;
                }

                .username {
                    font-size: 16px;
                    font-weight: 500;
                    text-align: center;
                }
            }

            &-navbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                height: 60px;
                border-top: 1px solid #F3F4F6;

                .dropdown {
                    display: inline-block;

                    &-toggle:after {
                        display: none;
                    }
                }
            }
        }

        .group-profile-feed {
            min-height: 500px;
        }

        .infolet {
            margin-bottom: 1rem;

            .media {
                &-icon {
                    display: flex;
                    justify-content: center;
                    width: 30px;
                    margin-right: 10px;

                    i {
                        font-size: 1.1rem;
                        color: #D1D5DB !important;
                    }
                }
            }
        }

        .btn-light {
            border-color: #F3F4F6;
        }
    }
</style>
