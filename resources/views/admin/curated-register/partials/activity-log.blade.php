<template v-if="loaded">
@if($email_verified_at === null)
<div class="alert alert-danger mb-3">
    <p class="mb-0 font-weight-bold">{{ __('admin_panel.curatedRegister.activityLog.emailNotVerified') }}</p>
</div>
@elseif($is_closed != true)
<div class="d-flex justify-content-between flex-column flex-md-row mb-4" style="gap:1rem">
    <button
        class="btn btn-success bg-gradient-success rounded-pill"
        v-on:click.prevent="handleAction('approve', $event)">
        {{ __('admin_panel.curatedRegister.activityLog.approve') }}
    </button>
    <button
        class="btn btn-danger bg-gradient-danger rounded-pill flex-grow-1"
        v-on:click.prevent="handleAction('reject', $event)">
        {{ __('admin_panel.curatedRegister.activityLog.reject') }}
    </button>
    <button
        class="btn rounded-pill px-md-5"
        :class="[ composeFormOpen ? 'btn-dark bg-gradient-dark' : 'btn-outline-dark' ]"
        v-on:click.prevent="handleAction('request', $event)">
        {{ __('admin_panel.curatedRegister.activityLog.requestDetails') }}
    </button>
    <button
        class="btn rounded-pill px-md-5"
        :class="[ messageFormOpen ? 'btn-dark bg-gradient-dark' : 'btn-outline-dark' ]"
        v-on:click.prevent="handleAction('message', $event)">
        {{ __('admin_panel.curatedRegister.activityLog.message') }}
    </button>
</div>

@else
    @if($is_rejected == true)
    <p>{!! __('admin_panel.curatedRegister.activityLog.wasRejected', ['date' => e($action_taken_at)]) !!}</p>
    @elseif($is_approved == true)
    <p>{!! __('admin_panel.curatedRegister.activityLog.wasApproved', ['date' => e($action_taken_at)]) !!}</p>
    @else
    <p>{{ __('admin_panel.curatedRegister.activityLog.wasClosed', ['date' => $action_taken_at]) }}</p>
    @endif
@endif

    <transition name="fade">
        <div v-show="composeFormOpen">
            <div class="card">
                <div class="card-body pt-0">
                    <p class="lead font-weight-bold text-center">{{ __('admin_panel.curatedRegister.activityLog.requestAdditionalDetails') }}</p>
                    <p class="text-muted">{{ __('admin_panel.curatedRegister.activityLog.requestAdditionalDetailsHelp') }}</p>

                    <div v-if="responseTemplates && responseTemplates.length" class="my-3">
                        <p class="small font-weight-bold mb-1">{{ __('admin_panel.curatedRegister.activityLog.templateResponses') }}</p>

                        <div class="d-grid">
                            <template v-for="tmpl in responseTemplates">
                                <button
                                    class="btn btn-lighter btn-sm py-1 font-weight-bold rounded-lg text-dark border border-muted px-3"
                                    style="font-size: 13px;"
                                    @click="useTemplate(tmpl)">
                                    <i class="far fa-plus mr-1 text-muted"></i> @{{ tmpl.name.slice(0, 25) }}
                                </button>
                            </template>
                        </div>
                    </div>

                    <div class="request-form">
                        <div class="form-group">
                            <label for="requestDetailsMessageInput" class="small text-muted">{{ __('admin_panel.curatedRegister.activityLog.yourMessage') }}</label>
                            <textarea
                                class="form-control text-dark"
                                id="requestDetailsMessageInput"
                                rows="5"
                                v-model="composeMessage"
                                style="white-space: pre-wrap;"
                                placeholder="{{ __('admin_panel.curatedRegister.activityLog.detailMessagePlaceholder') }}">
                            </textarea>
                            <p class="help-text small text-right">
                                <span>@{{ composeMessage && composeMessage.length ? composeMessage.length : 0 }}</span>
                                <span>/</span>
                                <span>2000</span>
                            </p>
                        </div>
                        <div class="d-flex">
                            <button
                                type="button"
                                class="btn btn-primary rounded-pill btn-sm px-4"
                                v-on:click.prevent="handleSend()">
                                {{ __('admin_panel.curatedRegister.activityLog.send') }}
                            </button>
                            <a
                                class="btn btn-dark rounded-pill btn-sm px-4"
                                :href="previewDetailsMessageUrl"
                                target="_blank">
                                {{ __('admin_panel.curatedRegister.activityLog.preview') }}
                            </a>
                            <a
                                v-if="composeMessage && composeMessage.length"
                                class="btn btn-outline-danger text-danger rounded-pill btn-sm px-4"
                                @click="composeMessage = null">
                                {{ __('admin_panel.curatedRegister.activityLog.clear') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>

    <transition name="fade">
        <div v-show="messageFormOpen">
            <div class="card">
                <div class="card-body pt-0">
                    <p class="lead font-weight-bold text-center">{{ __('admin_panel.curatedRegister.activityLog.sendMessage') }}</p>
                    <p class="text-muted">{{ __('admin_panel.curatedRegister.activityLog.sendMessageHelp') }}</p>

                    <div v-if="responseTemplates && responseTemplates.length" class="my-3">
                        <p class="small font-weight-bold mb-1">{{ __('admin_panel.curatedRegister.activityLog.templateResponses') }}</p>

                        <div class="d-grid">
                            <template v-for="tmpl in responseTemplates">
                                <button
                                    class="btn btn-lighter btn-sm py-1 font-weight-bold rounded-lg text-dark border border-muted px-3"
                                    style="font-size: 13px;"
                                    @click="useTemplateMessage(tmpl)">
                                    <i class="far fa-plus mr-1 text-muted"></i> @{{ tmpl.name.slice(0, 25) }}
                                </button>
                            </template>
                        </div>
                    </div>

                    <div class="request-form">
                        <div class="form-group">
                            <label for="sendMessageInput" class="small text-muted">{{ __('admin_panel.curatedRegister.activityLog.yourMessage') }}</label>
                            <textarea
                                class="form-control text-dark"
                                id="sendMessageInput"
                                rows="5"
                                v-model="messageBody"
                                style="white-space: pre-wrap;"
                                placeholder="{{ __('admin_panel.curatedRegister.activityLog.messagePlaceholder') }}">
                            </textarea>
                            <p class="help-text small text-right">
                                <span>@{{ messageBody && messageBody.length ? messageBody.length : 0 }}</span>
                                <span>/</span>
                                <span>500</span>
                            </p>
                        </div>
                        <div class="d-flex">
                            <button
                                type="button"
                                class="btn btn-primary rounded-pill btn-sm px-4"
                                v-on:click.prevent="handleMessageSend()">
                                {{ __('admin_panel.curatedRegister.activityLog.send') }}
                            </button>
                            <a
                                class="btn btn-dark rounded-pill btn-sm px-4"
                                :href="previewMessageUrl"
                                target="_blank">
                                {{ __('admin_panel.curatedRegister.activityLog.preview') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>

    <div class="card border">
        <div class="card-body">
            <p class="text-center font-weight-bold">{{ __('admin_panel.curatedRegister.activityLog.activityLog') }}</p>
            <div class="activity-log">
                <div v-if="!loaded" class="d-flex justify-content-center align-items-center py-5 my-5">
                    <b-spinner />
                </div>

                <template v-else>
                    <div
                        v-for="activity in activities"
                        class="activity-log-item"
                        :key="activity.timestamp">
                        <div v-if="activity.action === 'approved'" class="activity-log-item-icon bg-success">
                            <i class="far fa-check fa-lg text-white"></i>
                        </div>
                        <div v-else-if="activity.action === 'rejected'" class="activity-log-item-icon bg-danger">
                            <i class="far fa-times fa-lg text-white"></i>
                        </div>
                        <div v-else-if="activity.action === 'request_details'" class="activity-log-item-icon bg-lighter">
                            <i class="fas fa-exclamation fa-lg text-dark"></i>
                        </div>
                        <div v-else class="activity-log-item-icon">
                            <i class="fas fa-circle"></i>
                        </div>
                        <div class="activity-log-item-date">@{{ parseDate(activity.timestamp) }}<span>@{{ parseTime(activity.timestamp) }}</span></div>
                        <div class="activity-log-item-content"><span class="activity-log-item-content-title">@{{ activity.title }}</span><span class="activity-log-item-content-message" v-if="activity.message">@{{ strLimit(activity.message) }}</span></div>
                        <div class="d-flex" style="gap: 1rem;">
                            <div v-if="activity.link">
                                <a href="#" class="activity-log-item-content-link text-muted" @click.prevent="openModal(activity)">{{ __('admin_panel.curatedRegister.activityLog.details') }}</a>
                            </div>
                            <div v-if="activity.user_response">
                                <a href="#" class="activity-log-item-content-link" @click.prevent="openUserResponse(activity)">{{ __('admin_panel.curatedRegister.activityLog.viewUserResponse') }}</a>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>
<template v-else>
    <div class="card card-body d-flex justify-content-center align-items-center py-5">
        <b-spinner />
    </div>
</template>

@push('scripts')
<script type="text/javascript">
    let app = new Vue({
        el: '#panel',
        i18n: App.i18n(),

        data() {
            return {
                loaded: false,
                activities: [],
                composeFormOpen: false,
                messageFormOpen: false,
                composeMessage: null,
                messageBody: null,
                responseTemplates: [],
            }
        },

        mounted() {
            setTimeout(() => {
                this.fetchResponseTemplates();
                this.fetchActivities();
            }, 1000)
        },

        computed: {
            previewDetailsMessageUrl() {
                return `/i/admin/curated-onboarding/show/{{$id}}/preview-details-message?message=${encodeURIComponent(this.composeMessage)}`;
            },
            previewMessageUrl() {
                return `/i/admin/curated-onboarding/show/{{$id}}/preview-message?message=${encodeURIComponent(this.messageBody)}`;
            }
        },

        methods: {
            parseDate(timestamp) {
                const date = new Date(timestamp);

                return date.toLocaleDateString((document.documentElement.lang || 'en-US'), {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });
            },

            parseTime(timestamp) {
                const date = new Date(timestamp);

                return date.toLocaleTimeString((document.documentElement.lang || 'en-US'), {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true
                });
            },

            strLimit(str, len = 15) {
                if(str && str.length) {
                    return str.slice(0, len) + (str.length > 15 ? '...' : '');
                }
                return str;
            },

            fetchResponseTemplates() {
                axios.get('/i/admin/api/curated-onboarding/templates/get')
                .then(res => {
                    this.responseTemplates = res.data;
                })
            },

            fetchActivities() {
                axios.get('/i/admin/api/curated-onboarding/show/{{$id}}/activity-log')
                .then(res => {
                    this.activities = res.data;
                })
                .finally(() => {
                    this.loaded = true;
                })
            },

            handleAction(action, $event) {
                $event.currentTarget?.blur();

                switch(action) {
                    case 'approve':
                        this.handleApprove();
                    break;

                    case 'reject':
                        this.handleReject();
                    break;

                    case 'request':
                        this.messageFormOpen = false;
                        this.composeFormOpen = !this.composeFormOpen;
                    break;

                    case 'message':
                        this.composeFormOpen = false;
                        this.messageFormOpen = !this.messageFormOpen;
                    break;
                }
            },

            handleApprove() {
                swal({
                    title: @json(__('admin_panel.curatedRegister.activityLog.approveRequest')),
                    text: @json(__('admin_panel.curatedRegister.activityLog.approveRequestText')),
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willApprove) => {
                    if(willApprove) {
                        this.handleApproveAction();
                    } else {
                        swal(@json(__('admin_panel.curatedRegister.activityLog.approvalCancelled')), @json(__('admin_panel.curatedRegister.activityLog.approvalCancelledText')), "success");

                    }
                })
            },

            handleReject() {
                swal({
                    title: @json(__('admin_panel.common.areYouSure')),
                    text: @json(__('admin_panel.curatedRegister.activityLog.rejectRequestText')),
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willReject) => {
                    if (willReject) {
                        swal({
                            title: @json(__('admin_panel.curatedRegister.activityLog.chooseAction')),
                            text: @json(__('admin_panel.curatedRegister.activityLog.chooseActionText')),
                            icon: "warning",
                            buttons: {
                                cancel: @json(__('admin_panel.common.cancel')),
                                reject: {
                                    text: @json(__('admin_panel.curatedRegister.activityLog.rejectWithEmail')),
                                    value: "reject-email"
                                },
                                silent: {
                                    text: @json(__('admin_panel.curatedRegister.activityLog.silentlyReject')),
                                    value: "reject-silent"
                                }
                            },
                            dangerMode: true,
                        })
                        .then(res => {
                            if(!res) {
                                swal(@json(__('admin_panel.curatedRegister.activityLog.rejectionCancelled')), @json(__('admin_panel.curatedRegister.activityLog.rejectionCancelledText')), "success");
                            } else {
                                this.handleRejectAction(res);
                            }
                        })
                    } else {
                        swal(@json(__('admin_panel.curatedRegister.activityLog.rejectionCancelled')), @json(__('admin_panel.curatedRegister.activityLog.rejectionCancelledText')), "success");
                    }
                });
            },

            handleRejectAction(action) {
                axios.post('/i/admin/api/curated-onboarding/show/{{$id}}/reject', {
                    action: action
                }).then(res => {
                    window.location.href = '/i/admin/curated-onboarding/home?a=rj';
                    console.log(res);
                })
            },

            handleApproveAction() {
                axios.post('/i/admin/api/curated-onboarding/show/{{$id}}/approve')
                .then(res => {
                    window.location.href = '/i/admin/curated-onboarding/home?a=aj';
                })
            },

            handlePreview() {
                axios.post('/i/admin/api/curated-onboarding/show/{{$id}}/message/preview', {
                    message: this.composeMessage
                })
                .then(res => {
                    console.log(res.data);
                })
            },

            handleSend() {
                swal({
                    title: @json(__('admin_panel.curatedRegister.activityLog.confirm')),
                    text: @json(__('admin_panel.curatedRegister.activityLog.confirmSendRequest')),
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((hasConfirmed) => {
                    if(hasConfirmed) {
                        this.composeFormOpen = false;
                        this.loaded = false;
                        axios.post('/i/admin/api/curated-onboarding/show/{{$id}}/message/send', {
                            message: this.composeMessage
                        })
                        .then(res => {
                            this.composeMessage = null;
                            swal(@json(__('admin_panel.curatedRegister.activityLog.successfullySent')),'', 'success');
                            this.fetchActivities();
                        })
                    }
                })
            },

            openModal(activity) {
                swal(activity.title, activity.message)
            },

            openUserResponse(activity) {
                swal(@json(__('admin_panel.curatedRegister.activityLog.userResponse')), activity.user_response.message)
            },

            useTemplate(tmpl) {
                this.composeMessage = tmpl.content;
            },

            useTemplateMessage(tmpl) {
                this.messageBody = tmpl.content;
            },
        }
    });

</script>
@endpush

@push('styles')
<style type="text/css">
    .activity-log-item {
        border-left: 1px solid #e5e5e5;
        position: relative;
        padding: 2rem 1.5rem .5rem 2.5rem;
        font-size: .9rem;
        margin-left: 3rem;
        min-height: 5rem
    }
    .activity-log-item:last-child {
        padding-bottom: 4rem
    }
    .activity-log-item .activity-log-item-date {
        margin-bottom: .5rem;
        font-weight: bold;
        color: var(--primary);
    }
    .activity-log-item .activity-log-item-date span {
        color: #888;
        font-size: 85%;
        padding-left: .4rem;
        font-weight: 300;
    }
    .activity-log-item .activity-log-item-content {
        padding: .5rem .8rem;
        background-color: #f4f4f4;
        border-radius: .5rem;
    }
    .activity-log-item .activity-log-item-content span {
        display:block;
        color:#666;
    }
    .activity-log-item .activity-log-item-icon {
        line-height:2.6rem;
        position:absolute;
        left:-1.3rem;
        width:2.6rem;
        height:2.6rem;
        text-align:center;
        border-radius:50%;
        font-size:1.1rem;
        background-color:#fff;
        color:#fff
    }
    .activity-log-item .activity-log-item-icon {
        color:#e5e5e5;
        border:1px solid #e5e5e5;
        font-size:.6rem
    }
    .activity-log-item-content-title {
        font-weight: 500;
        font-size: 15px;
        color: #000000 !important;
    }
    .activity-log-item-content-message {
        font-weight: 400;
        font-size: 13px;
    }
    @media(min-width:992px) {
        .activity-log-item {
            margin-left:10rem
        }
        .activity-log-item .activity-log-item-date {
            position:absolute;
            left:-10rem;
            width:7.5rem;
            text-align:right
        }
        .activity-log-item .activity-log-item-date span {
            display:block
        }
    }
</style>
@endpush
