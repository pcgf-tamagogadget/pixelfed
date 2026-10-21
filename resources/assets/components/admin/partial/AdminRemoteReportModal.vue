<template>
    <b-modal
        v-model="isOpen"
        :title="$t('admin.remoteReport.title')"
        :ok-only="true"
        :ok-title="$t('common.close')"
        :lazy="true"
        :scrollable="true"
        ok-variant="outline-primary"
        v-on:hide="$emit('close')">
        <div v-if="isLoading" class="d-flex align-items-center justify-content-center">
            <b-spinner />
        </div>

        <template v-else>
            <div class="list-group">
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="text-muted small font-weight-bold">{{ $t('admin.remoteReport.instance') }}</div>
                    <div class="font-weight-bold">{{ model.instance }}</div>
                </div>
                <div v-if="model.message && model.message.length" class="list-group-item d-flex justify-content-between align-items-center flex-column gap-1">
                    <div class="text-muted small font-weight-bold mb-2">{{ $t('admin.remoteReport.message') }}</div>
                    <div class="text-wrap w-100" style="word-break:break-all;font-size:12.5px;">
                        <admin-read-more
                            :content="model.message"
                            font-size="11"
                            :step="true"
                            :initial-limit="100"
                            :stepLimit="1000" />
                    </div>
                </div>
            </div>
            <div class="list-group list-group-horizontal mt-3">
                <div
                    v-if="model && model.reported"
                    class="list-group-item d-flex align-items-center justify-content-between flex-row flex-grow-1"
                    style="gap:0.4rem;">
                    <div class="text-muted small font-weight-bold">{{ $t('admin.remoteReport.reportedAccount') }}</div>

                    <div class="d-flex justify-content-end flex-grow-1">
                        <a v-if="model.reported && model.reported.id" :href="`/i/web/profile/${model.reported.id}`" target="_blank" class="text-primary">
                            <div class="d-flex align-items-center" style="gap:0.61rem;">
                                <img
                                    :src="model.reported.avatar"
                                    width="30"
                                    height="30"
                                    style="object-fit: cover;border-radius:30px;"
                                    onerror="this.src='/storage/avatars/default.png';this.error=null;">

                                <div class="d-flex flex-column">
                                    <p class="font-weight-bold mb-0 text-break" style="font-size: 12px;max-width: 140px;line-height: 16px;" :class="[ model.reported.is_admin ? 'text-danger': '']">@{{model.reported.acct}}</p>
                                    <div class="d-flex text-muted mb-0" style="font-size: 10px;gap: 0.5rem;">
                                        <span>{{ $t('admin.remoteReport.followersCount', { count: prettyCount(model.reported.followers_count) }) }}</span>
                                        <span>·</span>
                                        <span>{{ $t('admin.remoteReport.joined', { time: timeAgo(model.reported.created_at) }) }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div
                    v-else
                    class="list-group-item d-flex align-items-center justify-content-center flex-column flex-grow-1">
                    <p class="font-weight-bold mb-0">{{ $t('admin.remoteReport.reportedAccountUnavailable') }}</p>
                    <i18n path="admin.remoteReport.reportedAccountUnavailableHelp" tag="p" class="small mb-0">
                        <template v-slot:action><strong>{{ $t('admin.remoteReport.closeReport') }}</strong></template>
                    </i18n>
                </div>
            </div>

            <div v-if="model && model.statuses && model.statuses.length" class="list-group mt-3">
                <admin-modal-post
                    v-for="(status, idx) in model.statuses"
                    :key="`admin-modal-post-remote-post:${status.id}:${idx}`"
                    :status="status"
                />
            </div>

            <div class="mt-4">
                <div>
                    <button
                        type="button"
                        class="btn btn-dark btn-block rounded-pill"
                        @click="handleAction('mark-read')">
                        {{ $t('admin.remoteReport.closeReport') }}
                    </button>

                    <button
                        type="button"
                        class="btn btn-outline-dark btn-block text-center rounded-pill"
                        style="word-break: break-all;"
                        @click="handleAction('mark-all-read-by-domain')">
                        <i18n path="admin.remoteReport.closeAllFrom" tag="span" class="font-weight-light"><template v-slot:instance><strong>{{ model.instance }}</strong></template></i18n>
                    </button>
                    <button
                        v-if="model.reported"
                        type="button"
                        class="btn btn-outline-dark btn-block rounded-pill flex-grow-1"
                        @click="handleAction('mark-all-read-by-username')">
                        <i18n path="admin.remoteReport.closeAllAgainst" tag="span" class="font-weight-light"><template v-slot:username><strong>&commat;{{ model.reported.username }}</strong></template></i18n>
                    </button>

                    <template
                        v-if="model && model.statuses && model.statuses.length && model.reported">
                        <hr class="mt-3 mb-1">

                        <div
                            class="d-flex flex-row mt-2"
                            style="gap:0.3rem;">
                            <button
                                type="button"
                                class="btn btn-outline-danger btn-block btn-sm rounded-pill mt-0"
                                @click="handleAction('cw-posts')">
                                {{ $t('admin.remoteReport.applyCwToPosts') }}
                            </button>

                            <button
                                type="button"
                                class="btn btn-outline-danger btn-block btn-sm rounded-pill mt-0"
                                @click="handleAction('unlist-posts')">
                                {{ $t('admin.remoteReport.unlistPosts') }}
                            </button>
                        </div>
                        <div class="d-flex flex-row mt-2">
                            <button
                                type="button"
                                class="btn btn-outline-danger btn-block btn-sm rounded-pill mt-0"
                                @click="handleAction('private-posts')">
                                {{ $t('admin.remoteReport.makePostsPrivate') }}
                            </button>
                            <button
                                type="button"
                                class="btn btn-outline-danger btn-block btn-sm rounded-pill mt-0"
                                @click="handleAction('delete-posts')">
                                {{ $t('admin.remoteReport.deletePosts') }}
                            </button>
                        </div>
                    </template>

                    <template v-else-if="model && model.statuses && !model.statuses.length && model.reported">
                        <hr class="mt-3 mb-1">

                        <div
                            class="d-flex flex-row mt-2"
                            style="gap:0.3rem;">
                            <button
                                type="button"
                                class="btn btn-outline-danger btn-block btn-sm rounded-pill mt-0"
                                @click="handleAction('cw-all-posts')">
                                {{ $t('admin.remoteReport.applyCwToAllPosts') }}
                            </button>

                            <button
                                type="button"
                                class="btn btn-outline-danger btn-block btn-sm rounded-pill mt-0"
                                @click="handleAction('unlist-all-posts')">
                                {{ $t('admin.remoteReport.unlistAllPosts') }}
                            </button>
                        </div>
                        <div
                            class="d-flex flex-row mt-2"
                            style="gap:0.3rem;">

                            <button
                                type="button"
                                class="btn btn-outline-danger btn-block btn-sm rounded-pill mt-0"
                                @click="handleAction('private-all-posts')">
                                {{ $t('admin.remoteReport.makeAllPostsPrivate') }}
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </b-modal>
</template>

<script>
    import AdminModalPost from "./AdminModalPost.vue";
    import AdminReadMore from "./AdminReadMore.vue";

    export default {
        props: {
            open: {
                type: Boolean,
                default: false
            },
            model: {
                type: Object
            }
        },

        components: {
            "admin-modal-post": AdminModalPost,
            "admin-read-more": AdminReadMore
        },

        watch: {
            open: {
                handler() {
                    this.isOpen = this.open;
                },
                immediate: true,
                deep: true,
            }
        },

        data() {
            return {
                isLoading: true,
                isOpen: false,
                actions: [
                    'mark-read',
                    'cw-posts',
                    'unlist-posts',
                    'private-posts',
                    'delete-posts',
                    'mark-all-read-by-domain',
                    'mark-all-read-by-username',
                    'cw-all-posts',
                    'unlist-all-posts',
                    'private-all-posts',
                ],
                actionMap: {
                    'cw-posts': 'admin.remoteReport.confirm.cwPosts',
                    'unlist-posts': 'admin.remoteReport.confirm.unlistPosts',
                    'delete-posts': 'admin.remoteReport.confirm.deletePosts',
                    'private-posts': 'admin.remoteReport.confirm.privatePosts',
                    'mark-all-read-by-domain': 'admin.remoteReport.confirm.markAllReadByDomain',
                    'mark-all-read-by-username': 'admin.remoteReport.confirm.markAllReadByUsername',
                    'cw-all-posts': 'admin.remoteReport.confirm.cwAllPosts',
                    'unlist-all-posts': 'admin.remoteReport.confirm.unlistAllPosts',
                    'private-all-posts': 'admin.remoteReport.confirm.privateAllPosts',
                }
            }
        },

        mounted() {
            setTimeout(() => {
                this.isLoading = false;
            }, 300);
        },

        methods: {
            prettyCount(str) {
                if(str) {
                   return str.toLocaleString('en-CA', { compactDisplay: "short", notation: "compact"});
                }
                return str;
            },

            timeAgo(str) {
                if(!str) {
                    return str;
                }
                return App.util.format.timeAgo(str);
            },

            formatDate(str) {
                let date = new Date(str);
                return new Intl.DateTimeFormat('default', {
                    month: 'long',
                    day: 'numeric',
                    year: 'numeric',
                    hour: 'numeric',
                    minute: 'numeric'
                }).format(date);
            },

            handleAction(action) {
                if(action === 'mark-read') {
                    axios.post('/i/admin/api/reports/remote/handle', {
                        id: this.model.id,
                        action: action,
                    }).then(res => {
                        console.log(res.data)
                    })
                    .finally(() => {
                        this.$emit('refresh');
                        this.$emit('close');
                    })
                    return;
                }

                swal({
                    title: this.$t('admin.remoteReport.confirmTitle'),
                    text: this.$t(this.actionMap[action]),
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                }).then(res => {
                    if(res === true) {
                        axios.post('/i/admin/api/reports/remote/handle', {
                            id: this.model.id,
                            action: action,
                        }).finally(() => {
                            this.$emit('refresh');
                            this.$emit('close');
                        })
                    }
                });
            }
        }
    }
</script>
