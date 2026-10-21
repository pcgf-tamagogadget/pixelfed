<template>
<div v-if="loaded">
    <div class="header bg-primary pb-2 mt-n4">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <p class="display-1 text-white d-inline-block mb-0">{{ $t('admin.settings.title') }}</p>
                        <p class="h3 text-white font-weight-light">{{ $t('admin.settings.subtitle') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="nav-wrapper">
                    <div class="nav flex-column nav-pills" id="tabs-icons-text" role="tablist" aria-orientation="vertical">
                        <div v-for="tab in tabs" class="nav-item">
                            <a class="nav-link mb-sm-3" :class="{ active: tabIndex === tab.id }" href="#" @click.prevent="toggleTab(tab.id)">
                                <i :class="tab.icon"></i>
                                <span class="ml-2">{{ $t(tab.title) }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-9">
                <div class="card shadow mt-3">
                    <div class="card-body">
                        <div class="tab-content">

                            <div v-if="tabIndex === 1" class="tab-pane fade show active">
                                <tab-header :title="$t('admin.settings.title')" :saving="isSubmitting" :saved="isSubmittingTimeout" @save="handleSave('overview')" />

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="card shadow-none border card-body" style="padding: 1.1rem 1.6rem">
                                            <div class="form-group mb-0">
                                                <label for="form-summary" class="font-weight-bold">{{ $t('admin.settings.overview.registrationStatus') }}</label>
                                                <select v-model="features.registration_status" class="form-control form-control-muted">
                                                    <option value="open" >{{ $t('admin.settings.overview.registrationOpen') }}</option>
                                                    <option value="filtered">{{ $t('admin.settings.overview.registrationFiltered') }}</option>
                                                    <option value="closed">{{ $t('admin.settings.overview.registrationClosed') }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <checkbox
                                            :name="$t('admin.settings.fields.cloudStorage.name')"
                                            :value="features.cloud_storage"
                                            :description="$t('admin.settings.fields.cloudStorage.description')"
                                            @change="handleChange($event, 'features', 'cloud_storage')"
                                        />

                                        <checkbox
                                            :name="$t('admin.settings.fields.activitypub.name')"
                                            :value="features.activitypub_enabled"
                                            :description="$t('admin.settings.fields.activitypub.description')"
                                            @change="handleChange($event, 'features', 'activitypub_enabled')"
                                        />

                                        <checkbox
                                            :name="$t('admin.settings.fields.authorizedFetchMode.name')"
                                            :value="features.authorized_fetch"
                                            :description="$t('admin.settings.fields.authorizedFetchMode.description')"
                                            @change="handleChange($event, 'features', 'authorized_fetch')"
                                        />

                                        <checkbox
                                            :name="$t('admin.settings.fields.accountMigration.name')"
                                            :value="features.account_migration"
                                            :description="$t('admin.settings.fields.accountMigration.description')"
                                            @change="handleChange($event, 'features', 'account_migration')"
                                        />
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <checkbox
                                            :name="$t('admin.settings.fields.mobileApis.name')"
                                            :value="features.mobile_apis"
                                            :description="$t('admin.settings.fields.mobileApis.description')"
                                            @change="handleChange($event, 'features', 'mobile_apis')"
                                        />

                                        <checkbox
                                            :name="$t('admin.settings.fields.stories.name')"
                                            :value="features.stories"
                                            :description="$t('admin.settings.fields.stories.description')"
                                            @change="handleChange($event, 'features', 'stories')"
                                        />

                                        <checkbox
                                            :name="$t('admin.settings.fields.instagramImport.name')"
                                            :value="features.instagram_import"
                                            :description="$t('admin.settings.fields.instagramImport.description')"
                                            @change="handleChange($event, 'features', 'instagram_import')"
                                        />

                                        <!-- <checkbox
                                            name="Allowlist Mode"
                                            :value="features.activitypub_enabled"
                                            description="Permit interactions only with instances you specifically authorize, both for sending and receiving."
                                            @change="handleChange($event, 'features', 'activitypub_enabled')"
                                        /> -->

                                        <checkbox
                                            :name="$t('admin.settings.fields.spamDetection.name')"
                                            :value="features.autospam_enabled"
                                            :description="$t('admin.settings.fields.spamDetection.description')"
                                            @change="handleChange($event, 'features', 'autospam_enabled')"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div v-else-if="tabIndex === 'landing'" class="tab-pane fade show active" role="tabpanel">
                                <tab-header :title="$t('admin.settings.tabs.landing')" :saving="isSubmitting" :saved="isSubmittingTimeout" @save="handleSave('landing')" />

                                <div class="row">
                                   <div class="col-12 col-md-6">
                                        <div class="card shadow-none border card-body" style="padding: 1.1rem 1.6rem">
                                            <div class="form-group mb-0">
                                                <label for="form-summary" class="font-weight-bold">{{ $t('admin.settings.landing.adminAccount') }}</label>
                                                <select v-model="landing.current_admin" class="form-control form-control-muted">
                                                    <option disabled="" value="0">{{ $t('admin.settings.landing.selectAdmin') }}</option>
                                                    <option v-for="(acct, index) in landing.admins" :key="'pfc-' + acct + index" :value="acct.profile_id">{{ acct.username }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <checkbox
                                            :name="$t('admin.settings.fields.showDirectory.name')"
                                            :value="landing.show_directory"
                                            :description="$t('admin.settings.fields.showDirectory.description')"
                                            @change="handleChange($event, 'landing', 'show_directory')"
                                        />
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <checkbox
                                            :name="$t('admin.settings.fields.showExploreFeed.name')"
                                            :value="landing.show_explore"
                                            :description="$t('admin.settings.fields.showExploreFeed.description')"
                                            @change="handleChange($event, 'landing', 'show_explore')"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div v-else-if="tabIndex === 'branding'" class="tab-pane fade show active" role="tabpanel">
                                <tab-header :title="$t('admin.settings.tabs.branding')" :saving="isSubmitting" :saved="isSubmittingTimeout" @save="handleSave('branding')" />

                                <div class="row">
                                    <div class="col-12 col-md-8">
                                        <div class="card shadow-none border card-body" style="padding: 1.1rem 1.6rem">
                                            <div class="form-group mb-1">
                                                <label for="form-summary" class="font-weight-bold">{{ $t('admin.settings.branding.serverName') }}</label>
                                                <input
                                                    class="form-control form-control-muted"
                                                    placeholder="Pixelfed"
                                                    v-model="branding.name" />
                                            </div>
                                            <p class="help-text small text-muted mb-0">
                                                {{ $t('admin.settings.branding.serverNameHelp') }}
                                            </p>
                                        </div>

                                        <div class="card shadow-none border card-body">
                                            <div class="form-group mb-1">
                                                <label for="form-summary" class="font-weight-bold">{{ $t('admin.settings.branding.shortDescription') }}</label>
                                                <textarea
                                                    class="form-control form-control-muted"
                                                    placeholder="Pixelfed"
                                                    rows="4"
                                                    v-model="branding.short_description"></textarea>
                                            </div>
                                            <p class="help-text small text-muted mb-0">
                                                {{ $t('admin.settings.branding.shortDescriptionHelp') }}
                                            </p>
                                        </div>

                                        <div class="card shadow-none border card-body">
                                            <div class="form-group mb-1">
                                                <label for="form-summary" class="font-weight-bold">{{ $t('admin.settings.branding.longDescription') }}</label>
                                                <textarea
                                                    class="form-control form-control-muted"
                                                    placeholder="Pixelfed"
                                                    rows="8"
                                                    v-model="branding.long_description"></textarea>
                                            </div>
                                            <p class="help-text small text-muted mb-0">
                                                {{ $t('admin.settings.branding.longDescriptionHelp') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <p>
                                            <a class="btn btn-dark btn-block" href="/i/admin/settings/custom-css">{{ $t('admin.settings.branding.editCustomCss') }}</a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div v-else-if="tabIndex === 'media'" class="tab-pane fade show active" role="tabpanel">
                                <tab-header :title="$t('admin.settings.tabs.media')" :saving="isSubmitting" :saved="isSubmittingTimeout" @save="handleSave('media')" />

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="card shadow-none border card-body">
                                            <div class="form-group mb-1">
                                                <label class="font-weight-bold text-muted">{{ $t('admin.settings.media.maxMediaSize') }}</label>
                                                <div class="input-group mb-0">
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        placeholder="15000"
                                                        :aria-label="$t('admin.settings.media.maxMediaSize')"
                                                        aria-describedby="maxMediaSize"
                                                        v-model="media.max_photo_size">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="maxMediaSize">= {{ maxMediaSizeToMb }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="help-text small text-muted mb-0">
                                                {{ $t('admin.settings.media.maxMediaSizeHelp') }}
                                            </p>
                                        </div>

                                        <checkbox
                                            :name="$t('admin.settings.fields.optimizeImages.name')"
                                            :value="media.optimize_image"
                                            :description="$t('admin.settings.fields.optimizeImages.description')"
                                            @change="handleChange($event, 'media', 'optimize_image')"
                                        />

                                        <checkbox
                                            :name="$t('admin.settings.fields.optimizeVideo.name')"
                                            :value="media.optimize_video"
                                            :description="$t('admin.settings.fields.optimizeVideo.description')"
                                            @change="handleChange($event, 'media', 'optimize_video')"
                                        />

                                        <div class="card shadow-none border card-body">
                                            <div class="form-group mb-1">
                                                <label class="font-weight-bold text-muted">{{ $t('admin.settings.media.mediaTypes') }}</label>

                                                <div class="list-group">
                                                    <div v-for="(mediaType, key) in mediaTypes" class="list-group-item py-2">
                                                        <div class="custom-control custom-checkbox">
                                                            <input
                                                                type="checkbox"
                                                                class="custom-control-input"
                                                                :name="key"
                                                                :id="key"
                                                                v-model="mediaTypes[key]">
                                                            <label class="custom-control-label font-weight-bold" :for="key">{{ key }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="help-text small text-muted mb-0">
                                                {{ $t('admin.settings.media.mediaTypesHelp') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="card shadow-none border card-body">
                                            <div class="form-group mb-1">
                                                <label class="font-weight-bold text-muted">{{ $t('admin.settings.media.albumLimit') }}</label>
                                                <input
                                                    type="number"
                                                    min="1"
                                                    max="20"
                                                    class="form-control"
                                                    name="max_album_length"
                                                    v-model="media.max_album_length">
                                            </div>
                                            <p class="help-text small text-muted mb-0">
                                                {{ $t('admin.settings.media.albumLimitHelp') }}
                                            </p>
                                        </div>

                                        <transition name="fade">
                                            <div v-if="media.optimize_image" class="card shadow-none border card-body">
                                                <div class="form-group mb-1">
                                                    <label class="font-weight-bold text-muted">{{ $t('admin.settings.media.imageQuality') }}</label>
                                                    <input
                                                        type="number"
                                                        min="20"
                                                        max="100"
                                                        class="form-control"
                                                        name="image_quality"
                                                        v-model="media.image_quality">
                                                </div>
                                                <p class="help-text small text-muted mb-0">
                                                    {{ $t('admin.settings.media.imageQualityHelp') }}
                                                </p>
                                            </div>
                                        </transition>
                                    </div>
                                </div>
                            </div>

                            <div v-else-if="tabIndex === 'platform'" class="tab-pane fade show active" role="tabpanel">
                                <tab-header :title="$t('admin.settings.tabs.platform')" :saving="isSubmitting" :saved="isSubmittingTimeout" @save="handleSave('platform')" />

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <checkbox
                                            :name="$t('admin.settings.fields.allowProfileEmbeds.name')"
                                            :value="platform.allow_profile_embeds"
                                            :description="$t('admin.settings.fields.allowProfileEmbeds.description')"
                                            @change="handleChange($event, 'platform', 'allow_profile_embeds')"
                                        />

                                        <div class="card shadow-none border card-body">
                                            <div class="form-group mb-0">
                                                <div class="custom-control custom-checkbox">
                                                    <input
                                                        type="checkbox"
                                                        name="allow_app_registrations"
                                                        class="custom-control-input"
                                                        id="platform1"
                                                        :disabled="features.registration_status !== 'open'"
                                                        v-model="platform.allow_app_registration">
                                                    <label class="custom-control-label font-weight-bold" for="platform1">{{ $t('admin.settings.platform.allowAppRegistrations') }}</label>
                                                </div>
                                                <p v-if="features.registration_status !== 'open'" class="mb-0 small text-muted">{{ $t('admin.settings.platform.requiresOpenRegistration') }}</p>
                                                <p v-else class="mb-0 small">{{ $t('admin.settings.platform.allowAppRegistrationsHelp') }}</p>
                                            </div>
                                        </div>

                                        <checkbox
                                            :name="$t('admin.settings.fields.customEmoji.name')"
                                            :value="platform.custom_emoji_enabled"
                                            :description="$t('admin.settings.fields.customEmoji.description')"
                                            @change="handleChange($event, 'platform', 'custom_emoji_enabled')"
                                        />

                                        <template v-if="features.registration_status === 'open' && features.allow_app_registration">
                                            <div class="card shadow-none border card-body">
                                                <div class="form-group mb-1">
                                                    <label class="font-weight-bold text-muted">app_registration_rate_limit_attempts</label>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        name="app_registration_rate_limit_attempts"
                                                        v-model="platform.app_registration_rate_limit_attempts">
                                                </div>
                                                <p class="help-text small text-muted mb-0">
                                                    app_registration_rate_limit_attempts.
                                                </p>
                                            </div>
                                            <div class="card shadow-none border card-body">
                                                <div class="form-group mb-1">
                                                    <label class="font-weight-bold text-muted">app_registration_rate_limit_decay</label>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        name="app_registration_rate_limit_decay"
                                                        v-model="platform.app_registration_rate_limit_decay">
                                                </div>
                                                <p class="help-text small text-muted mb-0">
                                                    app_registration_rate_limit_decay
                                                </p>
                                            </div>
                                        </template>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <checkbox
                                            :name="$t('admin.settings.fields.allowPostEmbeds.name')"
                                            :value="platform.allow_post_embeds"
                                            :description="$t('admin.settings.fields.allowPostEmbeds.description')"
                                            @change="handleChange($event, 'platform', 'allow_post_embeds')"
                                        />

                                        <div class="card shadow-none border card-body">
                                            <div class="form-group mb-1">
                                                <div class="custom-control custom-checkbox">
                                                    <input
                                                        type="checkbox"
                                                        name="hcaps"
                                                        class="custom-control-input"
                                                        id="hcp"
                                                        v-model="platform.captcha_enabled">
                                                    <label class="custom-control-label font-weight-bold" for="hcp">{{ $t('admin.settings.platform.enableCaptcha') }}</label>
                                                </div>
                                                <p class="help-text small text-muted mb-0">
                                                    {{ $t('admin.settings.platform.captchaHelp') }}
                                                </p>
                                            </div>
                                            <template v-if="platform.captcha_enabled">
                                                <hr class="my-2">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group my-1">
                                                            <label class="text-muted small font-weight-bold">{{ $t('admin.settings.platform.captchaProvider') }}</label>
                                                            <select
                                                                class="form-control"
                                                                name="captcha_driver"
                                                                v-model="platform.captcha_driver">
                                                                <option value="hcaptcha">hCaptcha</option>
                                                                <option value="turnstile">Cloudflare Turnstile</option>
                                                                <option value="cap">Cap</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- hCaptcha credentials -->
                                                <div class="row" v-if="platform.captcha_driver === 'hcaptcha'">
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group my-1">
                                                            <label class="text-muted small">{{ $t('admin.settings.platform.sitekey', { provider: 'hCaptcha' }) }}</label>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                name="captcha_hcaptcha_sitekey"
                                                                v-model="platform.captcha_hcaptcha_sitekey">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group my-1">
                                                            <label class="text-muted small">{{ $t('admin.settings.platform.secret', { provider: 'hCaptcha' }) }}</label>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                name="captcha_hcaptcha_secret"
                                                                v-model="platform.captcha_hcaptcha_secret">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Turnstile credentials -->
                                                <div class="row" v-else-if="platform.captcha_driver === 'turnstile'">
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group my-1">
                                                            <label class="text-muted small">{{ $t('admin.settings.platform.sitekey', { provider: 'Turnstile' }) }}</label>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                name="captcha_turnstile_sitekey"
                                                                v-model="platform.captcha_turnstile_sitekey">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group my-1">
                                                            <label class="text-muted small">{{ $t('admin.settings.platform.secret', { provider: 'Turnstile' }) }}</label>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                name="captcha_turnstile_secret"
                                                                v-model="platform.captcha_turnstile_secret">
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Cap credentials -->
                                                <div class="row" v-else-if="platform.captcha_driver === 'cap'">
                                                    <div class="col-12">
                                                        <div class="form-group my-1">
                                                            <label class="text-muted small">{{ $t('admin.settings.platform.endpoint', { provider: 'Cap' }) }}</label>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                name="captcha_cap_endpoint"
                                                                placeholder="https://cap.example.com"
                                                                v-model="platform.captcha_cap_endpoint">
                                                            <small class="form-text text-muted">{{ $t('admin.settings.platform.capEndpointHelp') }}</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group my-1">
                                                            <label class="text-muted small">{{ $t('admin.settings.platform.sitekey', { provider: 'Cap' }) }}</label>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                name="captcha_cap_sitekey"
                                                                v-model="platform.captcha_cap_sitekey">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div class="form-group my-1">
                                                            <label class="text-muted small">{{ $t('admin.settings.platform.secret', { provider: 'Cap' }) }}</label>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                name="captcha_cap_secret"
                                                                v-model="platform.captcha_cap_secret">
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="mt-2 mb-4">
                                                <label class="text-muted small font-weight-bold d-block mb-2">{{ $t('admin.settings.platform.captchaPages') }}</label>
                                                <div class="row">
                                                    <div class="col-12 col-lg-6 mb-3">
                                                        <div class="custom-control custom-checkbox">
                                                            <input
                                                                type="checkbox"
                                                                name="captcha_on_login"
                                                                class="custom-control-input"
                                                                id="captcha_on_login"
                                                                v-model="platform.captcha_on_login">
                                                            <label class="custom-control-label font-weight-bold" for="captcha_on_login">{{ $t('admin.settings.platform.pageLogin') }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-6 mb-3">
                                                        <div class="custom-control custom-checkbox">
                                                            <input
                                                                type="checkbox"
                                                                name="captcha_on_register"
                                                                class="custom-control-input"
                                                                id="captcha_on_register"
                                                                v-model="platform.captcha_on_register">
                                                            <label class="custom-control-label font-weight-bold" for="captcha_on_register">{{ $t('admin.settings.platform.pageRegister') }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-6 mb-3">
                                                        <div class="custom-control custom-checkbox">
                                                            <input
                                                                type="checkbox"
                                                                name="captcha_on_forgot_password"
                                                                class="custom-control-input"
                                                                id="captcha_on_forgot_password"
                                                                v-model="platform.captcha_on_forgot_password">
                                                            <label class="custom-control-label font-weight-bold" for="captcha_on_forgot_password">{{ $t('admin.settings.platform.pageForgotPassword') }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-6 mb-3">
                                                        <div class="custom-control custom-checkbox">
                                                            <input
                                                                type="checkbox"
                                                                name="captcha_on_password_reset"
                                                                class="custom-control-input"
                                                                id="captcha_on_password_reset"
                                                                v-model="platform.captcha_on_password_reset">
                                                            <label class="custom-control-label font-weight-bold" for="captcha_on_password_reset">{{ $t('admin.settings.platform.pagePasswordReset') }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-6 mb-3">
                                                        <div class="custom-control custom-checkbox">
                                                            <input
                                                                type="checkbox"
                                                                name="captcha_on_curated_register"
                                                                class="custom-control-input"
                                                                id="captcha_on_curated_register"
                                                                v-model="platform.captcha_on_curated_register">
                                                            <label class="custom-control-label font-weight-bold" for="captcha_on_curated_register">{{ $t('admin.settings.platform.pageCuratedRegister') }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-6 mb-3">
                                                        <div class="custom-control custom-checkbox">
                                                            <input
                                                                type="checkbox"
                                                                name="captcha_on_forgot_email"
                                                                class="custom-control-input"
                                                                id="captcha_on_forgot_email"
                                                                v-model="platform.captcha_on_forgot_email">
                                                            <label class="custom-control-label font-weight-bold" for="captcha_on_forgot_email">{{ $t('admin.settings.platform.pageForgotEmail') }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>

                                        <template v-if="features.registration_status === 'open' && features.allow_app_registration">
                                            <div class="card shadow-none border card-body">
                                                <div class="form-group mb-1">
                                                    <label class="font-weight-bold text-muted">app_registration_confirm_rate_limit_attempts</label>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        name="app_registration_confirm_rate_limit_attempts"
                                                        v-model="platform.app_registration_confirm_rate_limit_attempts">
                                                </div>
                                                <p class="help-text small text-muted mb-0">
                                                    app_registration_confirm_rate_limit_attempts.
                                                </p>
                                            </div>
                                            <div class="card shadow-none border card-body">
                                                <div class="form-group mb-1">
                                                    <label class="font-weight-bold text-muted">app_registration_confirm_rate_limit_decay</label>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        name="app_registration_confirm_rate_limit_decay"
                                                        v-model="platform.app_registration_confirm_rate_limit_decay">
                                                </div>
                                                <p class="help-text small text-muted mb-0">
                                                    app_registration_confirm_rate_limit_decay.
                                                </p>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <div v-else-if="tabIndex === 'posts'" class="tab-pane fade show active" role="tabpanel">
                                <tab-header :title="$t('admin.settings.tabs.posts')" :saving="isSubmitting" :saved="isSubmittingTimeout" @save="handleSave('posts')" />

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="card shadow-none border card-body">
                                            <div class="form-group mb-1">
                                                <label class="font-weight-bold text-muted">{{ $t('admin.settings.posts.maxCaptionLength') }}</label>
                                                <input
                                                    type="number"
                                                    min="1"
                                                    max="10000"
                                                    class="form-control"
                                                    name="max_caption_limit"
                                                    v-model="posts.max_caption_length">
                                            </div>
                                            <p class="help-text small text-muted mb-0">
                                                {{ $t('admin.settings.posts.maxCaptionLengthHelp') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="card shadow-none border card-body">
                                            <div class="form-group mb-1">
                                                <label class="font-weight-bold text-muted">{{ $t('admin.settings.posts.maxAltTextLength') }}</label>
                                                <input
                                                    type="number"
                                                    min="1"
                                                    max="10000"
                                                    class="form-control"
                                                    name="max_altext_length"
                                                    v-model="posts.max_altext_length">
                                            </div>
                                            <p class="help-text small text-muted mb-0">
                                                {{ $t('admin.settings.posts.maxAltTextLengthHelp') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div v-else-if="tabIndex === 'rules'" class="tab-pane fade show active" role="tabpanel">
                                <tab-header :title="$t('admin.settings.tabs.rules')" :saving="isSubmitting" :saved="isSubmittingTimeout" @save="handleSave('rules')" />

                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div v-if="hasDuplicateRulesComputed" class="alert alert-danger">
                                            <p class="font-weight-bold mb-0">{{ $t('admin.settings.rules.duplicates') }}</p>
                                        </div>
                                        <div class="position-relative">
                                            <div class="card shadow-none border">
                                                <div class="card-header py-2 bg-primary text-white font-weight-bold text-center">{{ $t('admin.settings.rules.activeRules') }}</div>
                                                <div class="list-group list-group-flush">
                                                    <div
                                                        v-for="(rule, idx) in rulesComputed"
                                                        class="list-group-item">
                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <div class="d-flex gap-1 align-items-start">
                                                                <div class="rule-badge">
                                                                    <div class="rule-badge-inner">{{ idx + 1 }}</div>
                                                                </div>
                                                                <admin-read-more
                                                                    :key="rule"
                                                                    class="text-dark rule-text"
                                                                    :content="rule"
                                                                    :maxLength="140"
                                                                    :initialLimit="30"
                                                                    fontSize="13" />
                                                            </div>

                                                            <button
                                                                class="btn btn-link btn-sm"
                                                                :disabled="isDeletingRule"
                                                                @click.prevent="handleDeleteRule(rule, idx, $event)">
                                                                <i class="fas fa-trash-alt text-danger"></i>
                                                            </button>
                                                        </div>
                                                    </div>


                                                    <div v-if="!rules || !rules.length" class="list-group-item">
                                                        <p class="text-center mb-0">{{ $t('admin.settings.rules.noRules') }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-if="!showAllRules && rules.length > 2" class="d-flex justify-content-center" style="position:absolute;width: 100%;padding-top: 10rem;bottom:0;background: linear-gradient(to bottom, rgba(255,255,255,0), rgba(255,255,255, 1));">
                                                <button class="btn btn-dark font-weight-bold rounded-pill btn-block" @click.prevent="showAllRules = true">{{ $t('admin.settings.rules.showAll') }}</button>
                                        </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="card shadow-none border card-body">
                                            <div class="form-group mb-1">
                                                <label class="font-weight-bold text-muted">{{ $t('admin.settings.rules.addNewRule') }}</label>
                                                <textarea
                                                    type="text"
                                                    class="form-control"
                                                    name="new_rule"
                                                    rows="5"
                                                    minlength="5"
                                                    maxlength="1000"
                                                    :placeholder="$t('admin.settings.rules.addNewRulePlaceholder')"
                                                    :disabled="isSubmittingNewRule || isDeletingRule"
                                                    v-model="newRule"></textarea>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="help-text small text-muted mb-0">
                                                    {{ $t('admin.settings.rules.addNewRuleHelp') }}
                                                </p>
                                                <p class="help-text small text-muted mb-0">
                                                    {{ newRule && newRule.length ? newRule.length : 0 }}/1000
                                                </p>
                                            </div>
                                            <hr class="my-2">
                                            <p class="mb-0">
                                                <button
                                                    class="btn btn-primary btn-sm btn-block font-weight-bold rounded-pill"
                                                    :disabled="!newRule || !newRule.length || isSubmittingNewRule || isDeletingRule"
                                                    @click.prevent="handleAddRule">{{ $t('admin.settings.rules.addRule') }}</button>
                                            </p>
                                        </div>

                                        <button v-if="rules && rules.length" class="btn btn-outline-danger rounded-pill btn-block btn-sm" @click.prevent="handleDeleteAllRules">{{ $t('admin.settings.rules.deleteAll') }}</button>
                                    </div>

                                    <div v-if="suggestedRulesComputed && suggestedRulesComputed.length" class="col-12 col-md-6">
                                        <div class="border-bottom pb-2 mb-3 d-flex justify-content-between align-items-center">
                                            <p class="font-weight-bold mb-0">{{ $t('admin.settings.rules.suggested') }}</p>
                                            <a v-if="!rules.length" class="font-weight-bold small" href="#" @click.prevent="importAllDefaultRules">{{ $t('admin.settings.rules.importAll') }}</a>
                                        </div>

                                        <div class="list-group">
                                            <a
                                                v-for="rule in suggestedRulesComputed"
                                                class="list-group-item small"
                                                href="#"
                                                @click.prevent="addSuggestedRule(rule, $event)">{{ rule }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div v-else-if="tabIndex === 'storage'" class="tab-pane fade show active" role="tabpanel">
                                <tab-header :title="$t('admin.settings.tabs.storage')" :saving="isSubmitting" :saved="isSubmittingTimeout" @save="handleSave('storage')" />

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="card shadow-none border card-body" style="padding: 1.1rem 1.6rem">
                                            <div class="form-group mb-0">
                                                <label for="form-summary" class="font-weight-bold">{{ $t('admin.settings.storage.primaryDisk') }}</label>
                                                <select v-model="storage.primary_disk" class="form-control form-control-muted">
                                                    <option value="local" >{{ $t('admin.settings.storage.local') }}</option>
                                                    <option value="cloud">Cloud/S3</option>
                                                </select>
                                            </div>
                                            <p class="help-text small text-muted mt-2 mb-0">
                                                {{ $t('admin.settings.storage.primaryDiskHelp') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="card border">
                                            <div class="card-header bg-gradient-primary">
                                                <p class="text-center mb-0 text-white font-weight-bold">{{ $t('admin.settings.storage.cloudDiskConfig') }}</p>
                                            </div>

                                            <div v-if="!showDiskConfig" class="card-body">
                                                <p class="text-center mb-0">
                                                    <a
                                                        class="btn btn-primary bg-gradient-primary shadow-lg rounded-pill"
                                                        href="#"
                                                        @click.prevent="showDiskConfig = true">
                                                        {{ $t('admin.settings.storage.viewEdit') }}
                                                    </a>
                                                </p>
                                            </div>
                                            <div v-else class="card-body">
                                                <div class="form-group mb-4 d-flex align-items-center gap-1">
                                                    <label for="form-summary" class="font-weight-bold mb-0">{{ $t('admin.settings.storage.disk') }}</label>
                                                    <select v-model="storage.disk_config.driver" class="form-control form-control-muted mb-0">
                                                        <option value="s3" >S3</option>
                                                        <option value="spaces">DigitalOcean Spaces</option>
                                                    </select>
                                                </div>

                                                <form-input
                                                    :name="$t('admin.settings.fields.key.name')"
                                                    :value="storage.disk_config.key"
                                                    description=""
                                                    :isCard="false"
                                                    :isInline="true"
                                                    @change="handleSubChange($event, 'storage', 'disk_config', 'key')"
                                                />
                                                <form-input
                                                    :name="$t('admin.settings.fields.secret.name')"
                                                    :value="storage.disk_config.secret"
                                                    description=""
                                                    :isCard="false"
                                                    :isInline="true"
                                                    @change="handleSubChange($event, 'storage', 'disk_config', 'secret')"
                                                />
                                                <form-input
                                                    :name="$t('admin.settings.fields.region.name')"
                                                    :value="storage.disk_config.region"
                                                    description=""
                                                    :isCard="false"
                                                    :isInline="true"
                                                    @change="handleSubChange($event, 'storage', 'disk_config', 'region')"
                                                />
                                                <form-input
                                                    :name="$t('admin.settings.fields.bucket.name')"
                                                    :value="storage.disk_config.bucket"
                                                    description=""
                                                    :isCard="false"
                                                    :isInline="true"
                                                    @change="handleSubChange($event, 'storage', 'disk_config', 'bucket')"
                                                />
                                                <form-input
                                                    :name="$t('admin.settings.fields.endpoint.name')"
                                                    :value="storage.disk_config.endpoint"
                                                    description=""
                                                    :isCard="false"
                                                    :isInline="true"
                                                    @change="handleSubChange($event, 'storage', 'disk_config', 'endpoint')"
                                                />
                                                <form-input
                                                    :name="$t('admin.settings.fields.visibility.name')"
                                                    :value="storage.disk_config.visibility"
                                                    description=""
                                                    :isCard="false"
                                                    :isInline="true"
                                                    :isDisabled="true"
                                                    @change="handleSubChange($event, 'storage', 'disk_config', 'visibility')"
                                                />
                                                <form-input
                                                    :name="$t('admin.settings.fields.url.name')"
                                                    :value="storage.disk_config.url"
                                                    description=""
                                                    :isCard="false"
                                                    :isInline="true"
                                                    @change="handleSubChange($event, 'storage', 'disk_config', 'url')"
                                                />
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div v-else-if="tabIndex === 'users'" class="tab-pane fade show active" role="tabpanel">
                                <tab-header :title="$t('admin.settings.tabs.users')" :saving="isSubmitting" :saved="isSubmittingTimeout" @save="handleSave('users')" />

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <checkbox
                                            :name="$t('admin.settings.fields.requireEmailVerifications.name')"
                                            :value="users.require_email_verification"
                                            :description="$t('admin.settings.fields.requireEmailVerifications.description')"
                                            @change="handleChange($event, 'users', 'require_email_verification')"
                                        />

                                        <form-input
                                            :name="$t('admin.settings.fields.maxUserBlocks.name')"
                                            :value="users.max_user_blocks.toString()"
                                            :description="$t('admin.settings.fields.maxUserBlocks.description')"
                                            @change="handleChange($event, 'users', 'max_user_blocks')"
                                        />

                                        <form-input
                                            :name="$t('admin.settings.fields.maxUserMutes.name')"
                                            :value="users.max_user_mutes.toString()"
                                            :description="$t('admin.settings.fields.maxUserMutes.description')"
                                            @change="handleChange($event, 'users', 'max_user_mutes')"
                                        />

                                        <form-input
                                            :name="$t('admin.settings.fields.maxUserDomainBlocks.name')"
                                            :value="users.max_domain_blocks.toString()"
                                            :description="$t('admin.settings.fields.maxUserDomainBlocks.description')"
                                            @change="handleChange($event, 'users', 'max_domain_blocks')"
                                        />
                                    </div>

                                    <div class="col-12 col-md-6">
                                        <div class="card shadow-none border card-body">
                                            <div class="form-group mb-0">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="enforce_account_limit" class="custom-control-input" id="users2" v-model="users.enforce_account_limit">
                                                    <label class="custom-control-label font-weight-bold" for="users2">{{ $t('admin.settings.users.enforceAccountLimit') }}</label>
                                                </div>
                                                <p class="mb-0 small">{{ $t('admin.settings.users.enforceAccountLimitHelp') }}</p>
                                            </div>
                                            <transition name="fade">
                                            <div v-if="users.enforce_account_limit">
                                                <hr class="my-2">
                                                <div class="form-group mb-1">
                                                    <div class="input-group mb-0">
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="15000"
                                                            :aria-label="$t('admin.settings.users.maxAccountSize')"
                                                            aria-describedby="maxMediaSize"
                                                            v-model="users.max_account_size">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">= {{maxAccountSizeToMb }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="help-text small text-muted mb-0">
                                                    {{ $t('admin.settings.users.maxAccountSizeHelp') }}
                                                </p>
                                            </div>
                                            </transition>
                                        </div>

                                        <div class="card shadow-none border">
                                            <div class="card-body">
                                                <div class="form-group mb-0">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="admin_autofollow" class="custom-control-input" id="users4" v-model="users.admin_autofollow">
                                                        <label class="custom-control-label font-weight-bold" for="users4">{{ $t('admin.settings.users.autofollow') }}</label>
                                                    </div>
                                                    <p class="mb-0 small">{{ $t('admin.settings.users.autofollowHelp') }}</p>
                                                </div>
                                            </div>
                                            <transition name="fade">
                                                <div v-if="users.admin_autofollow" class="list-group list-group-flush">
                                                    <div v-if="users.admin_autofollow_accounts?.length">
                                                        <div v-for="user in users.admin_autofollow_accounts" class="list-group-item">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <p class="font-weight-bold mb-0">&commat;{{ user }}</p>
                                                                <button class="btn btn-link p-0" @click.prevent="removeAutofollow(user, $event)"><i class="fas fa-trash-alt text-danger"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div v-else class="list-group-item">
                                                        <p class="text-center mb-0">{{ $t('admin.settings.users.noAutofollow') }}</p>
                                                    </div>
                                                </div>
                                            </transition>
                                            <transition name="fade">
                                                <div v-if="users.admin_autofollow && (users.admin_autofollow_accounts && users.admin_autofollow_accounts.length < 5)" class="card-footer">
                                                    <button
                                                        class="btn btn-primary btn-block rounded-pill"
                                                        @click.prevent="addAutofollow">{{ $t('admin.settings.users.addAutofollow') }}</button>
                                                </div>
                                            </transition>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div v-else>
    <div class="container my-5 py-5 text-center">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">{{ $t('common.loading') }}</span>
        </div>
    </div>
</div>
</template>

<script type="text/javascript">
    import AdminReadMore from "./partial/AdminReadMore.vue";
    import AdminSettingsTabHeader from "./partial/AdminSettingsTabHeader.vue";
    import Checkbox from "./partial/AdminSettingsCheckbox.vue";
    import FormInput from "./partial/AdminSettingsInput.vue";

    export default {
        components: {
            "admin-read-more": AdminReadMore,
            "tab-header": AdminSettingsTabHeader,
            "checkbox": Checkbox,
            "form-input": FormInput
        },

        data() {
            return {
                loaded: false,
                initialData: {},
                tabIndex: 1,
                tabbies: [
                    'landing',
                    'branding',
                    'media',
                    'posts',
                    'platform',
                    'rules',
                    'users',
                    'storage'
                ],
                tabs: [
                    // `title` holds a translation key, rendered with $t() in the template
                    { id: 1, title: "admin.settings.tabs.overview", icon: "far fa-home" },
                    // { id: 2, title: "Status", icon: "far fa-asterisk" },
                    { id: 'landing', title: "admin.settings.tabs.landing", icon: "far fa-info-circle" },
                    { id: 'branding', title: "admin.settings.tabs.branding", icon: "far fa-user-crown" },
                    { id: 'media', title: "admin.settings.tabs.media", icon: "far fa-image" },
                    { id: 'platform', title: "admin.settings.tabs.platform", icon: "far fa-database" },
                    { id: 'posts', title: "admin.settings.tabs.posts", icon: "far fa-heart" },
                    { id: 'rules', title: "admin.settings.tabs.rules", icon: "far fa-eye-slash" },
                    { id: 'storage', title: "admin.settings.tabs.storage", icon: "far fa-hdd" },
                    { id: 'users', title: "admin.settings.tabs.users", icon: "far fa-users" },
                ],

                isSubmitting: false,
                isSubmittingTimeout: false,
                isSubmittingTimeoutHandler: undefined,

                features: [],
                landing: {
                    current_admin: 0,
                },
                branding: [],
                media: [],
                mediaTypes: {
                    jpeg: false,
                    png: false,
                    gif: false,
                    webp: false,
                    avif: false,
                    heic: false,
                    mp4: false,
                    mov: false,
                },
                rules: [],
                users: [],
                posts: [],
                platform: [],
                storage: [],
                newRule: undefined,
                isSubmittingNewRule: false,
                isDeletingRule: false,
                suggestedRules: [],
                hasDuplicateRules: false,
                showAllRules: false,
                showDiskConfig: false,
            }
        },

        computed: {
            maxMediaSizeToMb: {
                get() {
                    if(!this.media || !this.media.max_photo_size) {
                        return '0.00 MB';
                    }

                    return (this.media.max_photo_size / 1000).toFixed(2) + ' MB';
                }
            },

            maxAccountSizeToMb: {
                get() {
                    if(!this.users || !this.users.max_account_size) {
                        return '0.00 MB';
                    }

                    const mb = (this.users.max_account_size / 1024);

                    if(mb > 1000000) {
                        return (mb / 1000000).toFixed(1) + 'TB';
                    }

                    if(mb > 1000) {
                        return (mb / 1024).toFixed(2) + 'GB';
                    }
                    return (this.users.max_account_size / 1024).toFixed(2) + ' MB';
                }
            },

            rulesComputed: {
                get() {
                    if(!this.rules || !this.rules.length) {
                        return [];
                    }

                    if(this.rules.length > 2) {
                        if(!this.showAllRules) {
                            return this.rules.slice(0, 2);
                        }
                    }
                    return this.rules;
                }
            },

            suggestedRulesComputed: {
                get() {
                    if(!this.rules || !this.rules.length) {
                        return this.suggestedRules;
                    }

                    return this.suggestedRules.filter(rule => {
                        if(this.rules.includes(rule)) {
                            return false;
                        }

                        return true;
                    });
                }
            },

            hasDuplicateRulesComputed: {
                get() {
                    if(!this.rules || !this.rules.length) {
                        return false;
                    }
                    const array = this.rules;
                    const duplicates = array.filter((item, index) => array.indexOf(item) !== index);

                    return duplicates.length;
                }
            },

            activeMediaTypes: {
                get() {
                    let res = '';

                    if(this.mediaTypes.jpeg) {
                        res += 'image/jpeg,'
                    }

                    if(this.mediaTypes.png) {
                        res += 'image/png,'
                    }

                    if(this.mediaTypes.gif) {
                        res += 'image/gif,'
                    }

                    if(this.mediaTypes.webp) {
                        res += 'image/webp,'
                    }

                    if(this.mediaTypes.avif) {
                        res += 'image/avif,'
                    }

                    if(this.mediaTypes.heic) {
                        res += 'image/heic,'
                    }

                    if(this.mediaTypes.mp4) {
                        res += 'video/mp4,'
                    }

                    if(this.mediaTypes.mov) {
                        res += 'video/mov,'
                    }

                    if(res.endsWith(',')) {
                        res = res.slice(0, -1);
                    }
                    return res;
                }
            }
        },

        mounted() {
            this.fetchInitialData();

            const params = new URL(window.location.href);

            if(params.searchParams.has('t')) {
                const tab = params.searchParams.get('t');
                if(this.tabbies.includes(tab)) {
                    this.tabIndex = tab;
                } else {
                    window.history.pushState(null, null, '/i/admin/settings')
                }
            }
        },

        methods: {
            toggleTab(idx) {
                clearTimeout(this.isSubmittingTimeoutHandler)
                this.isSubmittingTimeout = false;
                this.tabIndex = idx;
                this.showAllRules = false;
                if(this.tabbies.includes(idx)) {
                    window.history.pushState(null, null, '/i/admin/settings?t=' + idx);
                } else {
                    window.history.pushState(null, null, '/i/admin/settings');
                }
            },

            fetchInitialData() {
                axios.get('/i/admin/api/settings/fetch')
                .then(res => {
                    this.initialData = res.data;

                    this.features = res.data.features;
                    this.landing = res.data.landing;
                    this.branding = res.data.branding;
                    this.media = res.data.media;
                    this.setMediaTypes();
                    this.rules = res.data.rules;
                    this.users = res.data.users;
                    this.suggestedRules = res.data['suggested_rules'];
                    this.posts = res.data.posts;
                    this.platform = res.data.platform;
                    this.storage = res.data.storage;
                })
                .then(() => {
                    this.loaded = true;
                })
            },

            setMediaTypes() {
                const types = this.media.media_types.split(',');
                if(types && types.length) {
                    types.forEach((type) => {
                        let mime = type.split('/')[1];
                        if(['jpeg', 'png', 'gif', 'webp', 'avif', 'heic', 'mp4', 'mov'].includes(mime)) {
                            this.mediaTypes[mime] = true;
                        }
                    })
                }
            },

            formatCount(c) {
                return window.App.util.format.count(c);
            },

            formatDateTime(ts) {
                let date = new Date(ts);
                return new Intl.DateTimeFormat((document.documentElement.lang || 'en-US'), {dateStyle: 'medium', timeStyle: 'short'}).format(date);
            },

            formatDate(ts) {
                let date = new Date(ts);
                return new Intl.DateTimeFormat((document.documentElement.lang || 'en-US'), {month: 'short', year: 'numeric'}).format(date);
            },

            formatTimestamp(ts) {
                return window.App.util.format.timeAgo(ts);
            },

            handleSave(type) {
                this.isSubmitting = true;
                switch(type) {
                    case 'overview':
                        return this.saveHome();
                    break;
                    case 'landing':
                        return this.saveLanding();
                    break;
                    case 'branding':
                        return this.saveBranding();
                    break;
                    case 'posts':
                        return this.savePosts();
                    break;
                    case 'media':
                        return this.saveMedia();
                    break;
                    case 'platform':
                        return this.savePlatform();
                    break;
                    case 'users':
                        return this.saveUsers();
                    break;
                    case 'storage':
                        return this.saveStorage();
                    break;
                }
            },

            handleAddRule($event) {
                $event.currentTarget?.blur();
                this.isSubmittingNewRule = true;

                axios.post('/i/admin/api/settings/rules/add', {
                    rule: this.newRule
                }).then(res => {
                    this.rules.push(this.newRule);
                    this.newRule = undefined;
                    this.isSubmittingNewRule = false;
                    this.showAllRules = true;
                })
                .catch(err => {
                    if(err.response.data && err.response.data?.message) {
                        swal(this.$t('common.error'), err.response.data.message, 'error');
                    }
                    this.isSubmittingNewRule = false;
                })
            },

            addSuggestedRule(rule, $event) {
                $event.currentTarget?.blur();

                this.newRule = rule;
            },

            importAllDefaultRules($event) {
                $event.currentTarget?.blur();
                this.isSubmittingNewRule = true;
                this.showAllRules = true;
                for (var i = this.suggestedRules.length - 1; i >= 0; i--) {
                    const rule = this.suggestedRules[i]
                    setTimeout(() => {
                        axios.post('/i/admin/api/settings/rules/add', {
                            rule: rule
                        }).then(res => {
                            this.rules.push(rule);
                        })
                    }, (i * 300))
                }
                this.isSubmittingNewRule = false;
            },

            handleDeleteRule(rule, idx, $event) {
                $event.currentTarget?.blur();
                this.isDeletingRule = true;

                axios.post('/i/admin/api/settings/rules/delete', {
                    rule: rule,
                }).then(res => {
                    this.isDeletingRule = false;
                    this.rules = res.data;
                })
                .catch(err => {

                })
            },

            handleDeleteAllRules($event) {
                $event.currentTarget?.blur();
                this.isDeletingRule = true;

                swal({
                    title: this.$t('admin.settings.confirm'),
                    text: this.$t('admin.settings.rules.confirmDeleteAll'),
                    buttons: true,
                    dangerMode: true,
                }).then(res => {
                    if(res === true) {
                        axios.post('/i/admin/api/settings/rules/delete/all')
                        .then(res => {
                            this.isDeletingRule = false;
                            this.rules = []
                        })
                        .catch(err => {

                        })
                    } else {
                        this.isDeletingRule = false;
                    }
                })
            },

            removeAutofollow(username, $event) {
                $event.currentTarget?.blur();

                axios.post('/i/admin/api/settings/autofollow/delete', {
                    username: username
                }).then(res => {
                    this.users.admin_autofollow_accounts = res.data.accounts;
                }).catch(err => {
                    swal(this.$t('common.oops'), this.$t('admin.settings.errorTryLater'), "error");
                });
            },

            addAutofollow($event) {
                $event.currentTarget?.blur();

                swal({
                    text: this.$t('admin.settings.users.enterUsername'),
                    content: "input",
                    button: {
                        text: this.$t('admin.settings.users.addAutofollowButton'),
                        closeModal: false,
                    },
                }).then(username => {
                    if (!username) throw null;

                    axios.post('/i/admin/api/settings/autofollow/add', {
                        username: username
                    })
                    .then(res => {
                        if(!res.data.accounts.map(acc => acc.toLowerCase()).includes(username.toLowerCase())) {
                            swal(this.$t('common.oops'), this.$t('admin.settings.users.autofollowInvalid'), "error");
                        }
                        this.users.admin_autofollow_accounts = res.data.accounts;
                        swal.stopLoading();
                        swal.close();
                    })
                    .catch(err => {
                        if(err.response.data && err.response.data.message) {
                            swal(this.$t('common.error'), err.response.data.message, 'error');
                        } else {
                            swal(this.$t('common.oops'), this.$t('admin.settings.users.autofollowInvalid'), "error");
                        }
                        swal.stopLoading();
                        swal.close();
                    });
                })

            },

            saveHome() {
                axios.post('/i/admin/api/settings/update/home', {
                    registration_status: this.features.registration_status,
                    cloud_storage: this.features.cloud_storage,
                    activitypub_enabled: this.features.activitypub_enabled,
                    account_migration: this.features.account_migration,
                    mobile_apis: this.features.mobile_apis,
                    stories: this.features.stories,
                    instagram_import: this.features.instagram_import,
                    autospam_enabled: this.features.autospam_enabled,
                    authorized_fetch: this.features.authorized_fetch,
                }).then(res => {
                    this.isSubmitting = false;
                    this.isSubmittingTimeout = true;
                    this.isSubmittingTimeoutHandler = setTimeout(() => {
                        this.isSubmittingTimeout = false;
                    }, 4000);
                })
            },

            saveLanding() {
                axios.post('/i/admin/api/settings/update/landing', {
                    current_admin: this.landing.current_admin,
                    show_directory: this.landing.show_directory,
                    show_explore: this.landing.show_explore
                }).then(res => {
                    this.isSubmitting = false;
                    this.isSubmittingTimeout = true;
                    this.isSubmittingTimeoutHandler = setTimeout(() => {
                        this.isSubmittingTimeout = false;
                    }, 4000);
                })
            },

            saveBranding() {
                axios.post('/i/admin/api/settings/update/branding', {
                    name: this.branding.name,
                    short_description: this.branding.short_description,
                    long_description: this.branding.long_description
                }).then(res => {
                    this.isSubmitting = false;
                    this.isSubmittingTimeout = true;
                    this.isSubmittingTimeoutHandler = setTimeout(() => {
                        this.isSubmittingTimeout = false;
                    }, 4000);
                })
            },

            savePosts() {
                axios.post('/i/admin/api/settings/update/posts', {
                    max_caption_length: this.posts.max_caption_length,
                    max_altext_length: this.posts.max_altext_length,
                }).then(res => {
                    this.posts = res.data;
                    this.isSubmitting = false;
                    this.isSubmittingTimeout = true;
                    this.isSubmittingTimeoutHandler = setTimeout(() => {
                        this.isSubmittingTimeout = false;
                    }, 4000);
                })
                .catch(err => {
                    this.isSubmitting = false;
                    if(err.response.data && err.response.data.message) {
                        swal(this.$t('common.error'), err.response.data.message, 'error');
                    } else {
                        swal(this.$t('common.oops'), this.$t('admin.settings.errorOccurred'), 'error');
                    }
                })
            },

            saveMedia() {
                axios.post('/i/admin/api/settings/update/media', {
                    image_quality: this.media.image_quality,
                    max_album_length: this.media.max_album_length,
                    max_photo_size: this.media.max_photo_size,
                    media_types: this.activeMediaTypes,
                    optimize_image: this.media.optimize_image,
                    optimize_video: this.media.optimize_video,
                }).then(res => {
                    this.isSubmitting = false;
                    this.isSubmittingTimeout = true;
                    this.isSubmittingTimeoutHandler = setTimeout(() => {
                        this.isSubmittingTimeout = false;
                    }, 4000);
                }).catch(err => {
                    this.isSubmitting = false;
                    if(err.response.data && err.response.data.message) {
                        swal(this.$t('common.error'), err.response.data.message, 'error');
                    } else {
                        swal(this.$t('common.oops'), this.$t('admin.settings.errorOccurred'), 'error');
                    }
                })
            },

            savePlatform() {
                axios.post('/i/admin/api/settings/update/platform', {
                    allow_app_registration: this.platform.allow_app_registration,
                    app_registration_rate_limit_attempts: this.platform.app_registration_rate_limit_attempts,
                    app_registration_rate_limit_decay: this.platform.app_registration_rate_limit_decay,
                    app_registration_confirm_rate_limit_attempts: this.platform.app_registration_confirm_rate_limit_attempts,
                    app_registration_confirm_rate_limit_decay: this.platform.app_registration_confirm_rate_limit_decay,
                    allow_post_embeds: this.platform.allow_post_embeds,
                    allow_profile_embeds: this.platform.allow_profile_embeds,
                    captcha_enabled: this.platform.captcha_enabled,
                    captcha_driver: this.platform.captcha_driver,
                    captcha_hcaptcha_secret: this.platform.captcha_hcaptcha_secret,
                    captcha_hcaptcha_sitekey: this.platform.captcha_hcaptcha_sitekey,
                    captcha_turnstile_secret: this.platform.captcha_turnstile_secret,
                    captcha_turnstile_sitekey: this.platform.captcha_turnstile_sitekey,
                    captcha_cap_endpoint: this.platform.captcha_cap_endpoint,
                    captcha_cap_sitekey: this.platform.captcha_cap_sitekey,
                    captcha_cap_secret: this.platform.captcha_cap_secret,
                    captcha_on_login: this.platform.captcha_on_login,
                    captcha_on_register: this.platform.captcha_on_register,
                    captcha_on_forgot_password: this.platform.captcha_on_forgot_password,
                    captcha_on_password_reset: this.platform.captcha_on_password_reset,
                    captcha_on_forgot_email: this.platform.captcha_on_forgot_email,
                    captcha_on_curated_register: this.platform.captcha_on_curated_register,
                    custom_emoji_enabled: this.platform.custom_emoji_enabled,
                }).then(res => {
                    this.platform = res.data;
                    this.isSubmitting = false;
                    this.isSubmittingTimeout = true;
                    this.isSubmittingTimeoutHandler = setTimeout(() => {
                        this.isSubmittingTimeout = false;
                    }, 4000);
                })
                .catch(err => {
                    this.isSubmitting = false;
                    if(err.response.data && err.response.data.message) {
                        swal(this.$t('common.error'), err.response.data.message, 'error');
                    } else {
                        swal(this.$t('common.oops'), this.$t('admin.settings.errorOccurred'), 'error');
                    }
                })
            },

            saveUsers() {
                axios.post('/i/admin/api/settings/update/users', {
                    require_email_verification: this.users.require_email_verification,
                    enforce_account_limit: this.users.enforce_account_limit,
                    max_account_size: this.users.max_account_size,
                    admin_autofollow: this.users.admin_autofollow,
                    admin_autofollow_accounts: this.users.admin_autofollow_accounts,
                    max_user_blocks: this.users.max_user_blocks,
                    max_user_mutes: this.users.max_user_mutes,
                    max_domain_blocks: this.users.max_domain_blocks,
                }).then(res => {
                    this.isSubmitting = false;
                    this.isSubmittingTimeout = true;
                    this.isSubmittingTimeoutHandler = setTimeout(() => {
                        this.isSubmittingTimeout = false;
                    }, 4000);
                }).catch(err => {
                    if(err.response.data.message) {
                        swal(this.$t('common.error'), err.response.data.message, 'error');
                    } else {
                        swal(this.$t('common.error'), this.$t('admin.settings.unexpectedError'), 'error');
                    }
                    this.isSubmitting = false;
                })
            },

            saveStorage() {
                let data = this.showDiskConfig ?
                    {
                        primary_disk: this.storage.primary_disk,
                        update_disk: true,
                        disk_config: this.storage.disk_config,
                    } : {
                        primary_disk: this.storage.primary_disk,
                    }
                axios.post('/i/admin/api/settings/update/storage', data)
                .then(res => {
                    this.features.cloud_storage = res.data.primary_disk === 'cloud';
                    this.isSubmitting = false;
                    this.isSubmittingTimeout = true;
                    this.isSubmittingTimeoutHandler = setTimeout(() => {
                        this.isSubmittingTimeout = false;
                    }, 4000);
                }).catch(err => {
                    if(err.response.data.error) {
                        if(err.response.data.s3_vce) {
                            let el = document.createElement('div');
                            el.classList.add('text-left');
                            el.innerHTML = err.response.data.message;
                            let wrapper = document.createElement('div');
                            wrapper.appendChild(el);
                            swal({
                                title: this.$t('admin.settings.storage.invalidS3'),
                                content: wrapper,
                                icon: 'error'
                            });
                        } else {
                            swal(this.$t('common.error'), err.response.data.message, 'error');
                        }
                    }
                    this.isSubmitting = false;
                })
            },

            handleChange($event, cat, type) {
                switch(cat) {
                    case 'features':
                        this.features[type] = $event;
                    break;

                    case 'landing':
                        this.landing[type] = $event;
                    break;

                    case 'platform':
                        this.platform[type] = $event;
                    break;

                    case 'media':
                        this.media[type] = $event;
                    break;

                    case 'users':
                        this.users[type] = $event;
                    break;

                    case 'storage':
                        this.storage[type] = $event;
                    break;
                }
                console.log($event)
                console.log(type)
            },

            handleSubChange($event, cat, type, sub) {
                switch(cat) {
                    case 'features':
                        this.features[type][sub] = $event;
                    break;

                    case 'landing':
                        this.landing[type][sub] = $event;
                    break;

                    case 'platform':
                        this.platform[type][sub] = $event;
                    break;

                    case 'media':
                        this.media[type][sub] = $event;
                    break;

                    case 'users':
                        this.users[type][sub] = $event;
                    break;

                    case 'storage':
                        this.storage[type][sub] = $event;
                    break;
                }
                console.log($event)
                console.log(type)
            },
        },

        watch: {

        }
    }
</script>

<style lang="scss" scoped>
    .rule-badge {
        display: flex;
        width: 34px;
        height: 34px;
        justify-content: center;
        align-items: center;
        background-color: #fff;
        border-radius: 34px;
        border: 2px solid var(--primary);

        &-inner {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 26px;
            height: 26px;
            border-radius: 26px;
            background-color: var(--primary);
            color: #fff;
            font-weight: bold;
            font-size: 13px;
        }
    }
    .rule-text {
        max-width: 90%;
        margin-bottom: 0px;
        font-size: 14px;
    }
    .gap-1 {
        gap: 1rem;
    }
</style>
