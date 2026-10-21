<template>
<div class="container remote-auth-getting-started">
    <div class="row mt-5 justify-content-center">
        <div class="col-12 col-xl-5 col-md-7">
            <div v-if="!error" class="card shadow-none border" style="border-radius: 20px;">
                <div v-if="!loaded && !existing && !maxUsesReached" class="card-body d-flex align-items-center flex-column" style="min-height: 400px;">
                    <div class="w-100">
                        <p class="lead text-center font-weight-bold">{{ $t('spa.remoteAuthStart.title') }}</p>
                        <hr />
                    </div>
                    <div class="w-100 d-flex align-items-center justify-content-center flex-grow-1 flex-column gap-1">
                        <div class="position-relative w-100">
                            <p class="pa-center">{{ $t('spa.remoteAuthGettingStarted.pleaseWait') }}</p>
                            <instagram-loader></instagram-loader>
                        </div>
                        <div class="w-100">
                            <hr>
                            <p class="text-center mb-0">
                                <a class="font-weight-bold" href="/login">{{ $t('spa.remoteAuthStart.backToLogin') }}</a>
                            </p>
                        </div>
                    </div>
                </div>

                <div v-else-if="!loaded && !existing && maxUsesReached" class="card-body d-flex align-items-center flex-column" style="min-height: 660px;">
                    <div class="w-100">
                        <p class="lead text-center font-weight-bold">{{ $t('spa.remoteAuthStart.title') }}</p>
                        <hr />
                    </div>
                    <div class="w-100 d-flex align-items-center justify-content-center flex-grow-1 flex-column gap-1">

                        <p class="lead text-center font-weight-bold mt-3">{{ $t('common.oops') }}</p>

                        <p class="mb-2 text-center">{{ $t('spa.remoteAuthGettingStarted.cannotComplete') }}</p>
                        <p class="mb-3 text-center text-xs">{{ $t('spa.remoteAuthGettingStarted.maxUsesReached') }}</p>
                    </div>

                    <div class="w-100">
                        <p class="text-center mb-0">
                            <a class="font-weight-bold" href="/site/contact">{{ $t('spa.remoteAuthGettingStarted.contactSupport') }}</a>
                        </p>
                        <hr>
                        <p class="text-center mb-0">
                            <a class="font-weight-bold" href="/login">{{ $t('spa.remoteAuthStart.backToLogin') }}</a>
                        </p>
                    </div>
                </div>

                <div v-else-if="!loaded && existing" class="card-body d-flex align-items-center flex-column" style="min-height: 660px;">
                    <div class="w-100">
                        <p class="lead text-center font-weight-bold">{{ $t('spa.remoteAuthStart.title') }}</p>
                        <hr />
                    </div>
                    <div class="w-100 d-flex align-items-center justify-content-center flex-grow-1 flex-column gap-1">
                        <b-spinner />
                        <div class="text-center">
                            <p class="lead mb-0">{{ $t('spa.remoteAuthGettingStarted.welcomeBack') }}</p>
                            <p class="text-xs text-muted">{{ $t('spa.remoteAuthGettingStarted.loggingIn') }}</p>
                        </div>
                    </div>
                </div>

                <register-form v-else :initialData="prefill" v-on:setCanReload="setCanReload" />
            </div>
            <div v-else class="card shadow-none border">
                <div class="card-body d-flex align-items-center flex-column" style="min-height: 660px;">
                    <div class="w-100">
                        <p class="lead text-center font-weight-bold">{{ $t('spa.remoteAuthStart.title') }}</p>
                        <hr />
                    </div>
                    <div class="w-100 d-flex align-items-center justify-content-center flex-grow-1 flex-column gap-1">

                        <p class="lead text-center font-weight-bold mt-3">{{ $t('spa.remoteAuthGettingStarted.somethingWrong') }}</p>

                        <p class="mb-3">{{ $t('spa.remoteAuthGettingStarted.tryAgainLater') }}</p>

                        <p class="text-xs text-muted mb-1">{{ $t('spa.remoteAuthGettingStarted.reasons') }}</p>

                        <ul class="text-xs text-muted">
                            <li>{{ $t('spa.remoteAuthGettingStarted.reasonUnreachable') }}</li>
                            <li>{{ $t('spa.remoteAuthGettingStarted.reasonUnsupported') }}</li>
                            <li>{{ $t('spa.remoteAuthGettingStarted.reasonDisabled') }}</li>
                            <li>{{ $t('spa.remoteAuthGettingStarted.reasonNoRemoteLogin') }}</li>
                        </ul>
                    </div>

                    <div class="w-100">
                        <hr>
                        <p class="text-center mb-0">
                            <a class="font-weight-bold" href="/login">{{ $t('spa.remoteAuthStart.backToLogin') }}</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script type="text/javascript">
    import { InstagramLoader } from 'vue-content-loader';
    import RegisterForm from './partials/RegisterForm.vue';

    export default {
        components: {
            InstagramLoader,
            RegisterForm
        },

        data() {
            return {
                loaded: false,
                error: false,
                prefill: false,
                existing: undefined,
                maxUsesReached: undefined,
                tab: 'loading',
                canReload: false,
            }
        },

        mounted() {
            this.validateSession();

            window.onbeforeunload = function () {
                if(!this.canReload) {
                    alert('You are trying to leave.');
                    return false;
                }
            }
        },

        methods: {
            validateSession() {
                axios.post('/auth/raw/mastodon/s/check')
                .then(res => {
                    if(!res && !res.hasOwnProperty('action')) {
                        swal(this.$t('common.oops'), this.$t('spa.remoteAuthGettingStarted.unexpectedError'), 'error');
                        return;
                    }

                    switch(res.data.action) {
                        case 'onboard':
                            this.getPrefillData();
                            return;
                        break;

                        case 'redirect_existing_user':
                            this.existing = true;
                            this.canReload = true;
                            window.onbeforeunload = undefined;
                            this.redirectExistingUser();
                            return;
                        break;

                        case 'max_uses_reached':
                            this.maxUsesReached = true;
                            this.canReload = true;
                            window.onbeforeunload = undefined;
                            return;
                        break;

                        default:
                            this.error = true;
                            return;
                        break;
                    }
                })
                .catch(error => {
                    this.canReload = true;
                    window.onbeforeunload = undefined;
                    this.error = true;
                })
            },

            setCanReload() {
                this.canReload = true;
                window.onbeforeunload = undefined;
            },

            redirectExistingUser() {
                this.canReload = true;
                setTimeout(() => {
                    this.handleLogin();
                }, 1500);
            },

            handleLogin() {
                axios.post('/auth/raw/mastodon/s/login')
                .then(res => {
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                })
                .catch(err => {
                    this.canReload = false;
                    this.error = true;
                })
            },

            getPrefillData() {
                axios.post('/auth/raw/mastodon/s/prefill')
                .then(res => {
                    this.prefill = res.data;
                })
                .catch(error => {
                    this.error = true;
                })
                .finally(() => {
                    setTimeout(() => {
                        this.loaded = true;
                    }, 1000);
                })
            }
        }
    }
</script>

<style lang="scss">
    @use '../../../../node_modules/bootstrap/scss/bootstrap';

    .remote-auth-getting-started {
        .text-xs {
            font-size: 12px;
        }

        .gap-1 {
            gap: 1rem;
        }

        .opacity-50 {
            opacity: .3;
        }

        .server-btn {
            @extend .btn;
            @extend .btn-primary;
            @extend .btn-block;
            @extend .rounded-pill;
            @extend .font-weight-light;

            background: linear-gradient(#6364FF, #563ACC);
        }

        .other-server-btn {
            @extend .btn;
            @extend .btn-dark;
            @extend .btn-block;
            @extend .rounded-pill;
            @extend .font-weight-light;
        }

        .pa-center {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%);
            font-weight: 600;
            font-size: 16px;
        }
    }
</style>
