<template>
    <div class="admin-invite-component">
        <div class="admin-invite-component-inner">
            <div class="card bg-dark">
                <div v-if="tabIndex === 0" class="card-body d-flex align-items-center justify-content-center">
                    <div class="text-center">
                        <b-spinner variant="muted" />
                        <p class="text-muted mb-0">{{ $t('common.loading') }}</p>
                    </div>
                </div>

                <div v-else-if="tabIndex === 1" class="card-body">
                    <div class="d-flex justify-content-center my-3">
                        <img src="/img/pixelfed-icon-color.png" width="60" :alt="$t('admin.invite.logoAlt')" />
                    </div>
                    <div class="d-flex flex-column align-items-center justify-content-center">
                        <p class="lead mb-1 text-muted">{{ $t('admin.invite.invitedToJoin') }}</p>
                        <p class="h3 mb-2">{{ instance.uri }}</p>
                        <p class="mb-0 text-muted">
                            <span>{{ $t('admin.invite.usersCount', { count: instance.stats.user_count.toLocaleString('en-CA', { compactDisplay: "short", notation: "compact"}) }) }}</span>
                            <span>·</span>
                            <span>{{ $t('admin.invite.postsCount', { count: instance.stats.status_count.toLocaleString('en-CA', { compactDisplay: "short", notation: "compact"}) }) }}</span>
                        </p>

                        <div v-if="inviteConfig.message != 'You\'ve been invited to join'">
                            <div class="admin-message">
                                <p class="small text-light mb-0">{{ $t('admin.invite.messageFromAdmins') }}</p>
                                {{ inviteConfig.message }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <div class="form-group">
                            <label for="username">{{ $t('admin.invite.username') }}</label>
                            <input
                                type="text"
                                class="form-control form-control-lg"
                                :placeholder="$t('admin.invite.usernamePlaceholder')"
                                minlength="2"
                                maxlength="30"
                                v-model="form.username" />

                            <p v-if="errors.username" class="form-text text-danger">
                                <i class="far fa-exclamation-triangle mr-1"></i>
                                {{ errors.username }}
                            </p>
                        </div>

                        <button
                            class="btn btn-primary btn-block font-weight-bold"
                            @click="proceed(tabIndex)"
                            :disabled="isProceeding || !form.username || form.username.length < 2">
                            <template v-if="isProceeding">
                                <b-spinner small />
                            </template>
                            <template v-else>
                                {{ $t('common.continue') }}
                            </template>
                        </button>

                        <p class="login-link">
                            <a href="/login">{{ $t('admin.invite.alreadyHaveAccount') }}</a>
                        </p>

                        <i18n path="admin.invite.registerTerms" tag="p" class="register-terms">
                            <template v-slot:terms><a href="/site/terms">{{ $t('admin.invite.termsOfService') }}</a></template>
                            <template v-slot:privacy><a href="/site/privacy">{{ $t('admin.invite.privacyPolicy') }}</a></template>
                        </i18n>
                    </div>
                </div>

                <div v-else-if="tabIndex === 2" class="card-body">
                    <div class="d-flex justify-content-center my-3">
                        <img src="/img/pixelfed-icon-color.png" width="60" :alt="$t('admin.invite.logoAlt')" />
                    </div>
                    <div class="d-flex flex-column align-items-center justify-content-center">
                        <p class="lead mb-1 text-muted">{{ $t('admin.invite.invitedToJoin') }}</p>
                        <p class="h3 mb-2">{{ instance.uri }}</p>
                    </div>
                    <div class="mt-5">
                        <div class="form-group">
                            <label for="username">{{ $t('admin.invite.emailAddress') }}</label>
                            <input
                                type="email"
                                class="form-control form-control-lg"
                                :placeholder="$t('admin.invite.emailPlaceholder')"
                                v-model="form.email" />

                            <p v-if="errors.email" class="form-text text-danger">
                                <i class="far fa-exclamation-triangle mr-1"></i>
                                {{ errors.email }}
                            </p>
                        </div>

                        <button
                            class="btn btn-primary btn-block font-weight-bold"
                            @click="proceed(tabIndex)"
                            :disabled="isProceeding || !form.email || !validateEmail()">
                            <template v-if="isProceeding">
                                <b-spinner small />
                            </template>
                            <template v-else>
                                {{ $t('common.continue') }}
                            </template>
                        </button>
                    </div>
                </div>

                <div v-else-if="tabIndex === 3" class="card-body">
                    <div class="d-flex justify-content-center my-3">
                        <img src="/img/pixelfed-icon-color.png" width="60" :alt="$t('admin.invite.logoAlt')" />
                    </div>
                    <div class="d-flex flex-column align-items-center justify-content-center">
                        <p class="lead mb-1 text-muted">{{ $t('admin.invite.invitedToJoin') }}</p>
                        <p class="h3 mb-2">{{ instance.uri }}</p>
                    </div>
                    <div class="mt-5">
                        <div class="form-group">
                            <label for="username">{{ $t('admin.invite.password') }}</label>
                            <input
                                type="password"
                                class="form-control form-control-lg"
                                :placeholder="$t('admin.invite.passwordPlaceholder')"
                                minlength="8"
                                v-model="form.password" />

                            <p v-if="errors.password" class="form-text text-danger">
                                <i class="far fa-exclamation-triangle mr-1"></i>
                                {{ errors.password }}
                            </p>
                        </div>

                        <button
                            class="btn btn-primary btn-block font-weight-bold"
                            @click="proceed(tabIndex)"
                            :disabled="isProceeding || !form.password || form.password.length < 8">
                            <template v-if="isProceeding">
                                <b-spinner small />
                            </template>
                            <template v-else>
                                {{ $t('common.continue') }}
                            </template>
                        </button>
                    </div>
                </div>

                <div v-else-if="tabIndex === 4" class="card-body">
                    <div class="d-flex justify-content-center my-3">
                        <img src="/img/pixelfed-icon-color.png" width="60" :alt="$t('admin.invite.logoAlt')" />
                    </div>
                    <div class="d-flex flex-column align-items-center justify-content-center">
                        <p class="lead mb-1 text-muted">{{ $t('admin.invite.invitedToJoin') }}</p>
                        <p class="h3 mb-2">{{ instance.uri }}</p>
                    </div>
                    <div class="mt-5">
                        <div class="form-group">
                            <label for="username">{{ $t('admin.invite.confirmPassword') }}</label>
                            <input
                                type="password"
                                class="form-control form-control-lg"
                                :placeholder="$t('admin.invite.passwordPlaceholder')"
                                minlength="8"
                                v-model="form.password_confirm" />

                            <p v-if="errors.password_confirm" class="form-text text-danger">
                                <i class="far fa-exclamation-triangle mr-1"></i>
                                {{ errors.password_confirm }}
                            </p>
                        </div>

                        <button
                            class="btn btn-primary btn-block font-weight-bold"
                            @click="proceed(tabIndex)"
                            :disabled="isProceeding || !form.password_confirm || form.password !== form.password_confirm">
                            <template v-if="isProceeding">
                                <b-spinner small />
                            </template>
                            <template v-else>
                                {{ $t('common.continue') }}
                            </template>
                        </button>
                    </div>
                </div>

                <div v-else-if="tabIndex === 5" class="card-body">
                    <div class="d-flex justify-content-center my-3">
                        <img src="/img/pixelfed-icon-color.png" width="60" :alt="$t('admin.invite.logoAlt')" />
                    </div>
                    <div class="d-flex flex-column align-items-center justify-content-center">
                        <p class="lead mb-1 text-muted">{{ $t('admin.invite.invitedToJoin') }}</p>
                        <p class="h3 mb-2">{{ instance.uri }}</p>
                    </div>
                    <div class="mt-5">
                        <div class="form-group">
                            <label for="username">{{ $t('admin.invite.displayName') }}</label>
                            <input
                                type="text"
                                class="form-control form-control-lg"
                                :placeholder="$t('admin.invite.displayNamePlaceholder')"
                                minlength="8"
                                v-model="form.display_name" />

                            <p v-if="errors.display_name" class="form-text text-danger">
                                <i class="far fa-exclamation-triangle mr-1"></i>
                                {{ errors.display_name }}
                            </p>
                        </div>

                        <button
                            class="btn btn-primary btn-block font-weight-bold"
                            @click="proceed(tabIndex)"
                            :disabled="isProceeding">
                            <template v-if="isProceeding">
                                <b-spinner small />
                            </template>
                            <template v-else>
                                {{ $t('common.continue') }}
                            </template>
                        </button>
                    </div>
                </div>

                <div v-else-if="tabIndex === 6" class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-center my-3">
                        <img src="/img/pixelfed-icon-color.png" width="60" :alt="$t('admin.invite.logoAlt')" />
                    </div>
                    <div class="d-flex flex-column align-items-center justify-content-center">
                        <p class="lead mb-1 text-muted">{{ $t('admin.invite.invitedToJoin') }}</p>
                        <p class="h3 mb-2">{{ instance.uri }}</p>
                    </div>
                    <div class="mt-5 d-flex align-items-center justify-content-center flex-column flex-grow-1">
                        <b-spinner variant="muted" />
                        <p class="text-muted">{{ $t('admin.invite.registering') }}</p>
                    </div>
                </div>

                <div v-else-if="tabIndex === 'invalid-code'" class="card-body d-flex align-items-center justify-content-center">
                    <div>
                        <h1 class="text-center">{{ $t('admin.invite.invalidCode') }}</h1>
                        <hr>
                        <p class="text-muted mb-1">{{ $t('admin.invite.invalidCodeIntro') }}</p>
                        <ul class="text-muted">
                            <li>{{ $t('admin.invite.reasonTypos') }}</li>
                            <li>{{ $t('admin.invite.reasonUsed') }}</li>
                            <li>{{ $t('admin.invite.reasonMaxUses') }}</li>
                            <li>{{ $t('admin.invite.reasonExpired') }}</li>
                            <li>{{ $t('admin.invite.reasonRateLimited') }}</li>
                        </ul>
                        <hr>
                        <a href="/" class="btn btn-primary btn-block rounded-pill font-weight-bold">{{ $t('admin.invite.goBackHome') }}</a>
                    </div>
                </div>

                <div v-else class="card-body">
                    <p>{{ $t('admin.invite.errorOccurred') }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    export default {
        props: ['code'],

        data() {
            return {
                instance: {},
                inviteConfig: {},
                tabIndex: 0,
                isProceeding: false,
                errors: {
                    username: undefined,
                    email: undefined,
                    password: undefined,
                    password_confirm: undefined
                },

                form: {
                    username: undefined,
                    email: undefined,
                    password: undefined,
                    password_confirm: undefined,
                    display_name: undefined,
                }
            }
        },

        mounted() {
            this.fetchInstanceData();
        },

        methods: {
            fetchInstanceData() {
                axios.get('/api/v1/instance')
                .then(res => {
                    this.instance = res.data;
                })
                .then(res => {
                    this.verifyToken();
                })
                .catch(err => {
                    console.log(err);
                })
            },

            verifyToken() {
                axios.post('/api/v1.1/auth/invite/admin/verify', {
                    token: this.code,
                })
                .then(res => {
                    this.tabIndex = 1;
                    this.inviteConfig = res.data;
                })
                .catch(err => {
                    this.tabIndex = 'invalid-code';
                })
            },

            checkUsernameAvailability() {
                axios.post('/api/v1.1/auth/invite/admin/uc', {
                    token: this.code,
                    username: this.form.username
                })
                .then(res => {
                    if(res && res.data) {
                        this.isProceeding = false;
                        this.tabIndex = 2;
                    } else {
                        this.tabIndex = 'invalid-code';
                        this.isProceeding = false;
                    }
                })
                .catch(err => {
                    if(err.response.data && err.response.data.username) {
                        this.errors.username = err.response.data.username[0];
                        this.isProceeding = false;
                    } else {
                        this.tabIndex = 'invalid-code';
                        this.isProceeding = false;
                    }
                })
            },

            checkEmailAvailability() {
                axios.post('/api/v1.1/auth/invite/admin/ec', {
                    token: this.code,
                    email: this.form.email
                })
                .then(res => {
                    if(res && res.data) {
                        this.isProceeding = false;
                        this.tabIndex = 3;
                    } else {
                        this.tabIndex = 'invalid-code';
                        this.isProceeding = false;
                    }
                })
                .catch(err => {
                    if(err.response.data && err.response.data.email) {
                        this.errors.email = err.response.data.email[0];
                        this.isProceeding = false;
                    } else {
                        this.tabIndex = 'invalid-code';
                        this.isProceeding = false;
                    }
                })
            },

            validateEmail() {
                const email = this.form?.email?.trim();

                if (!email || email.length > 254) {
                    return false;
                }

                const pattern = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)+$/;

                return pattern.test(email);
            },

            handleRegistration() {
                var $form = $('<form>', {
                    action: '/api/v1.1/auth/invite/admin/re',
                    method: 'post'
                });
                let fields = {
                    '_token': document.head.querySelector('meta[name="csrf-token"]').content,
                    token: this.code,
                    username: this.form.username,
                    name: this.form.display_name,
                    email: this.form.email,
                    password: this.form.password,
                    password_confirm: this.form.password_confirm
                };

                $.each(fields, function(key, val) {
                     $('<input>').attr({
                         type: "hidden",
                         name: key,
                         value: val
                     }).appendTo($form);
                });
                $form.appendTo('body').submit();
            },

            proceed(cur) {
                this.isProceeding = true;
                event.currentTarget.blur();

                switch(cur) {
                    case 1:
                        this.checkUsernameAvailability();
                    break;

                    case 2:
                        this.checkEmailAvailability();
                    break;

                    case 3:
                        this.isProceeding = false;
                        this.tabIndex = 4;
                    break;

                    case 4:
                        this.isProceeding = false;
                        this.tabIndex = 5;
                    break;

                    case 5:
                        this.tabIndex = 6;
                        this.handleRegistration();
                    break;
                }
            }
        }
    }
</script>

<style lang="scss">
    .admin-invite-component {
        font-family: var(--font-family-sans-serif);

        &-inner {
            display: flex;
            width: 100wv;
            height: 100vh;
            justify-content: center;
            align-items: center;

            .card {
                width: 100%;
                color: #fff;
                padding: 1.25rem 2.5rem;
                border-radius: 10px;
                min-height: 530px;

                @media(min-width: 768px) {
                    width: 30%;
                }

                label {
                    color: var(--muted);
                    font-weight: bold;
                    text-transform: uppercase;
                }

                .login-link {
                    margin-top: 10px;
                    font-weight: 600;
                }

                .register-terms {
                    font-size: 12px;
                    color: var(--muted);
                }

                .form-control {
                    color: #fff;
                    background-color: #1c1c1e;
                    border-color: var(--dropdown-item-hover-color) !important;

                    &::placeholder {
                        color: var(--muted);
                    }

                    &:focus {
                        color: #fff;
                        background-color: #1c1c1e;
                        border-color: #8E54E9 !important;
                        box-shadow: 0 0 0 0.2rem rgba(142, 84, 233, 0.25);
                    }
                }

                .admin-message {
                    margin-top: 20px;
                    border: 1px solid var(--dropdown-item-hover-color);
                    color: var(--text-lighter);
                    padding: 1rem;
                    border-radius: 5px;
                }
            }
        }
    }
</style>
