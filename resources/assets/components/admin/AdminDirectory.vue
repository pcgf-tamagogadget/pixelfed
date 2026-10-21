<template>
    <div v-if="loaded">
        <div class="header bg-primary pb-2 mt-n4">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <p class="display-1 text-white d-inline-block mb-0">{{ $t('admin.directory.title') }}</p>
                            <p class="h3 text-white font-weight-light">{{ $t('admin.directory.subtitle') }}</p>
                        </div>

                        <div class="col-lg-6 col-5">
                            <p class="text-right">
                                <button class="btn btn-outline-white btn-lg px-5 py-2" @click="save">{{ $t('admin.directory.saveChanges') }}</button>
                            </p>
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
                                    <div v-if="!isSubmitting && !state.awaiting_approval && !state.is_active" class="d-flex align-items-center justify-content-center">
                                        <div class="text-center mb-4">
                                            <p>
                                                <i class="far fa-exclamation-triangle fa-5x text-lighter"></i>
                                            </p>
                                            <p class="display-3 mb-1">{{ $t('admin.directory.awaitingSubmission') }}</p>
                                            <p v-if="!state.is_eligible && !state.submission_exists" class="lead mt-0 text-muted">{{ $t('admin.directory.listingNotCompleted') }}</p>
                                            <div v-else-if="state.is_eligible && !state.submission_exists" class="mb-4">
                                                <p class="lead mt-0 text-muted">{{ $t('admin.directory.listingReady') }}</p>
                                                <button
                                                    class="btn btn-primary btn-lg font-weight-bold px-5 text-uppercase"
                                                    @click="handleSubmit">
                                                    {{ $t('admin.directory.submitServer') }}
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-else-if="!isSubmitting && state.awaiting_approval && !state.is_active">
                                        <div class="card card-body shadow-none border d-flex align-items-center justify-content-center py-5">
                                            <p class="display-3 mb-1">{{ $t('admin.directory.awaitingApproval') }}</p>
                                            <p class="text-primary mb-1">{{ $t('admin.directory.awaitingApprovalBody') }}</p>
                                            <p class="small text-muted mb-0">{{ $t('admin.directory.contactIfWaiting') }}</p>
                                        </div>
                                    </div>

                                    <div v-else-if="!isSubmitting && state.awaiting_approval && state.is_active">
                                        <div class="card card-body shadow-none border d-flex align-items-center justify-content-center py-5">
                                            <p class="display-3 mb-1">{{ $t('admin.directory.awaitingUpdateApproval') }}</p>
                                            <p class="text-primary mb-1">{{ $t('admin.directory.awaitingUpdateApprovalBody') }}</p>
                                            <p class="small text-muted mb-0">{{ $t('admin.directory.contactIfWaiting') }}</p>
                                        </div>
                                    </div>

                                    <div v-else-if="!isSubmitting && !state.awaiting_approval && state.is_active">
                                        <div class="card card-body shadow-none border d-flex align-items-center justify-content-center py-5">
                                            <h2 class="font-weight-bold">{{ $t('admin.directory.activeListing') }}</h2>
                                            <p class="my-3">
                                                <i class="far fa-check-circle fa-4x text-success"></i>
                                            </p>
                                            <i18n path="admin.directory.listingActive" tag="p" class="mt-2 mb-0">
                                                <template v-slot:site><a href="#" class="font-weight-bold">pixelfed.org</a></template>
                                            </i18n>

                                            <button
                                                class="btn btn-primary btn-sm mt-3 font-weight-bold px-5 text-uppercase"
                                                @click="handleSubmit">
                                                {{ $t('admin.directory.updateListing') }}
                                            </button>
                                        </div>
                                    </div>

                                    <div v-else-if="isSubmitting">
                                        <div class="card card-body shadow-none border d-flex align-items-center justify-content-center py-5">
                                            <b-spinner variant="primary" />
                                            <p class="lead my-0 text-primary">{{ $t('admin.directory.sendingSubmission') }}</p>
                                        </div>
                                    </div>

                                    <div v-else>
                                        <div class="card card-body shadow-none border d-flex align-items-center justify-content-center py-5">
                                            <p class="display-3 mb-1">{{ $t('admin.directory.unexpectedError') }}</p>
                                            <p class="text-primary mb-1">{{ $t('admin.directory.askForAssistance') }}</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="card text-left">
                                                <div class="list-group list-group-flush">
                                                    <div class="list-group-item">
                                                        <template v-if="requirements.curated_onboarding === true">
                                                            <i class="far fa-exclamation-circle text-success"></i>
                                                            <span class="ml-2 font-weight-bold">
                                                                {{ $t('admin.directory.req.curatedRegistration') }}
                                                            </span>
                                                        </template>
                                                        <template v-else>
                                                            <i
                                                                class="far"
                                                                :class="[ requirements.open_registration ? 'fa-check-circle text-success' : 'fa-exclamation-circle text-danger']"></i>
                                                            <span class="ml-2 font-weight-bold">
                                                                {{ requirements.open_registration ? $t('admin.directory.req.openRegistration') : $t('admin.directory.req.closedRegistration') }}
                                                            </span>
                                                        </template>
                                                    </div>

                                                    <div class="list-group-item">
                                                        <i
                                                            class="far"
                                                            :class="[ requirements.oauth_enabled ? 'fa-check-circle text-success' : 'fa-exclamation-circle text-danger']"></i>
                                                        <span class="ml-2 font-weight-bold">
                                                            {{ requirements.oauth_enabled ? $t('admin.directory.req.oauthEnabled') : $t('admin.directory.req.oauthDisabled') }}
                                                        </span>
                                                    </div>

                                                    <div class="list-group-item">
                                                        <i
                                                            class="far"
                                                            :class="[ requirements.activitypub_enabled ? 'fa-check-circle text-success' : 'fa-exclamation-circle text-danger']"></i>
                                                        <span class="ml-2 font-weight-bold">
                                                            {{ requirements.activitypub_enabled ? $t('admin.directory.req.activitypubEnabled') : $t('admin.directory.req.activitypubDisabled') }}
                                                        </span>
                                                    </div>

                                                    <div class="list-group-item">
                                                        <i
                                                            class="far"
                                                            :class="[ form.summary && form.summary.length && form.location && form.location.length ? 'fa-check-circle text-success' : 'fa-exclamation-circle text-danger']"></i>
                                                        <span class="ml-2 font-weight-bold">
                                                            {{ form.summary && form.summary.length && form.location && form.location.length ? $t('admin.directory.req.serverDetailsConfigured') : $t('admin.directory.req.serverDetailsMissing') }}
                                                        </span>
                                                    </div>

                                                    <div class="list-group-item">
                                                        <i
                                                            class="far"
                                                            :class="[ requirements_validator && requirements_validator.length == 0 ? 'fa-check-circle text-success' : 'fa-exclamation-circle text-danger']"></i>
                                                        <span class="ml-2 font-weight-bold">
                                                            {{ requirements_validator && requirements_validator.length == 0 ? $t('admin.directory.req.featuresValid') : $t('admin.directory.req.featuresInvalid') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="card text-left">
                                                <div class="list-group list-group-flush">

                                                    <div class="list-group-item">
                                                        <i
                                                            class="far"
                                                            :class="[ form.contact_account ? 'fa-check-circle text-success' : 'fa-exclamation-circle text-danger']"></i>
                                                        <span class="ml-2 font-weight-bold">
                                                            {{ form.contact_account ? $t('admin.directory.req.adminConfigured') : $t('admin.directory.req.adminMissing') }}
                                                        </span>
                                                    </div>

                                                    <div class="list-group-item">
                                                        <i
                                                            class="far"
                                                            :class="[ form.contact_email ? 'fa-check-circle text-success' : 'fa-exclamation-circle text-danger']"></i>
                                                        <span class="ml-2 font-weight-bold">
                                                            {{ form.contact_email ? $t('admin.directory.req.emailConfigured') : $t('admin.directory.req.emailMissing') }}
                                                        </span>
                                                    </div>
                                                    <div class="list-group-item">
                                                        <i
                                                            class="far"
                                                            :class="[ selectedPosts && selectedPosts.length ? 'fa-check-circle text-success' : 'fa-exclamation-circle text-danger']"></i>
                                                        <span class="ml-2 font-weight-bold">
                                                            {{ selectedPosts && selectedPosts.length ? $t('admin.directory.req.postsConfigured') : $t('admin.directory.req.postsMissing') }}
                                                        </span>
                                                    </div>

                                                    <div class="list-group-item">
                                                        <i
                                                            class="far"
                                                            :class="[ form.privacy_pledge ? 'fa-check-circle text-success' : 'fa-exclamation-circle text-danger']"></i>
                                                        <span class="ml-2 font-weight-bold">
                                                            {{ form.privacy_pledge ? $t('admin.directory.req.pledgeConfigured') : $t('admin.directory.req.pledgeMissing') }}
                                                        </span>
                                                    </div>

                                                    <div class="list-group-item">
                                                        <i
                                                            class="far"
                                                            :class="[ communityGuidelines && communityGuidelines.length ? 'fa-check-circle text-success' : 'fa-exclamation-circle text-danger']"></i>
                                                        <span class="ml-2 font-weight-bold">
                                                            {{ communityGuidelines && communityGuidelines.length ? $t('admin.directory.req.guidelinesConfigured') : $t('admin.directory.req.guidelinesMissing') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div v-else-if="tabIndex === 2" class="tab-pane fade show active">
                                    <p class="description">Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
                                </div>

                                <div v-else-if="tabIndex === 3" class="tab-pane fade show active" role="tabpanel">
                                    <h2 class="display-4 mb-0">{{ $t('admin.directory.tabs.serverDetails') }}</h2>
                                    <p class="small text-muted">{{ $t('admin.directory.serverDetails.subtitle') }}</p>
                                    <hr class="mt-0">

                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="card shadow-none border card-body">
                                                <div class="form-group mb-0">
                                                    <label for="form-summary" class="font-weight-bold">{{ $t('admin.directory.serverDetails.summary') }}</label>
                                                    <textarea
                                                        class="form-control form-control-muted"
                                                        id="form-summary"
                                                        rows="3"
                                                        :placeholder="$t('admin.directory.serverDetails.summaryPlaceholder')"
                                                        v-model="form.summary"></textarea>
                                                    <p class="help-text small text-muted text-right">
                                                        {{ form.summary && form.summary.length ? form.summary.length : 0 }}/140
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="card shadow-none border card-body">
                                                <div class="form-group mb-0">
                                                    <label for="form-summary" class="font-weight-bold">{{ $t('admin.directory.serverDetails.location') }}</label>
                                                    <select v-model="form.location" class="form-control form-control-muted">
                                                        <option selected disabled value="0">{{ $t('admin.directory.serverDetails.selectCountry') }}</option>
                                                        <option v-for="c in initialData.countries" :value="c">{{ c }}</option>
                                                    </select>
                                                    <p class="form-text small text-muted">{{ $t('admin.directory.serverDetails.selectCountryHelp') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="list-group mb-4">
                                        <div class="list-group-item">
                                            <label class="font-weight-bold mb-0">{{ $t('admin.directory.serverDetails.banner') }}</label>
                                            <p class="small">{{ $t('admin.directory.serverDetails.bannerHelp') }}</p>

                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <div class="card mb-0 shadow-none border">
                                                        <div v-if="!form.banner_image" class="card-body bg-primary text-white">
                                                            <p class="text-center mb-2">
                                                                <i class="far fa-exclamation-circle fa-2x"></i>
                                                            </p>
                                                            <p class="text-center mb-0">{{ $t('admin.directory.serverDetails.noBanner') }}</p>
                                                        </div>
                                                        <div v-else>
                                                            <a :href="form.banner_image" target="_blank">
                                                                <img :src="form.banner_image" class="card-img-top">
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div v-if="!isUploadingBanner" class="custom-file">
                                                        <input
                                                            ref="bannerImageRef"
                                                            type="file"
                                                            class="custom-file-input"
                                                            id="banner_image"
                                                            @change="uploadBannerImage"
                                                            >
                                                        <label class="custom-file-label" for="banner_image">{{ $t('admin.directory.serverDetails.chooseFile') }}</label>
                                                        <p class="form-text text-muted small mb-0">{{ $t('admin.directory.serverDetails.bannerSize') }}</p>
                                                        <i18n path="admin.directory.serverDetails.bannerFormat" tag="p" class="form-text text-muted small mb-0">
                                                            <template v-slot:jpeg><kbd>JPEG</kbd></template>
                                                            <template v-slot:png><kbd>PNG</kbd></template>
                                                        </i18n>
                                                        <div v-if="form.banner_image && !form.banner_image.endsWith('default.jpg')">
                                                            <button
                                                                class="btn btn-danger font-weight-bold btn-block mt-5"
                                                                @click="deleteBannerImage">{{ $t('admin.directory.serverDetails.deleteBanner') }}</button>
                                                        </div>
                                                    </div>
                                                    <div v-else class="text-center">
                                                        <b-spinner variant="primary" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="card shadow-none border card-body">
                                                <div class="form-group mb-0">
                                                    <label for="form-summary" class="font-weight-bold">{{ $t('admin.directory.serverDetails.primaryLanguage') }}</label>
                                                    <select v-model="form.primary_locale" class="form-control form-control-muted" disabled>
                                                        <option v-for="c in initialData.available_languages" :value="c.code">{{ c.name }}</option>
                                                    </select>
                                                    <i18n path="admin.directory.serverDetails.primaryLanguageHelp" tag="p" class="form-text text-muted small mb-0">
                                                        <template v-slot:env><kbd>APP_LOCALE</kbd></template>
                                                    </i18n>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div v-else-if="tabIndex === 4" class="tab-pane fade show active" role="tabpanel">
                                    <h2 class="display-4 mb-0">{{ $t('admin.directory.tabs.adminContact') }}</h2>
                                    <p class="small text-muted">{{ $t('admin.directory.adminContact.subtitle') }}</p>
                                    <hr class="mt-0">

                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div v-if="initialData.admins.length" class="form-group">
                                                <label for="form-summary" class="font-weight-bold">{{ $t('admin.directory.adminContact.designatedAdmin') }}</label>
                                                <select v-model="form.contact_account" class="form-control form-control-muted">
                                                    <option disabled="" value="0">{{ $t('admin.directory.adminContact.selectAdmin') }}</option>
                                                    <option v-for="(acct, index) in initialData.admins" :key="'pfc-' + acct + index" :value="acct.pid">{{ acct.username }}</option>
                                                </select>
                                            </div>
                                            <div v-else class="px-3 pb-2 pt-0 border border-danger rounded">
                                                <p class="lead font-weight-bold text-danger">{{ $t('admin.directory.adminContact.noAdmins') }}</p>
                                                <ul class="text-danger">
                                                    <li>{{ $t('admin.directory.adminContact.mustBeActive') }}</li>
                                                    <li>{{ $t('admin.directory.adminContact.mustHave2fa') }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="form-summary" class="font-weight-bold">{{ $t('admin.directory.adminContact.publicEmail') }}</label>
                                                <input
                                                    class="form-control form-control-muted"
                                                    placeholder="info@example.org"
                                                    v-model="form.contact_email" />
                                                <p class="help-text small text-muted">
                                                    {{ $t('admin.directory.adminContact.validEmail') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div v-else-if="tabIndex === 5" class="tab-pane fade show active" role="tabpanel">
                                    <h2 class="display-4 mb-0">{{ $t('admin.directory.tabs.favouritePosts') }}</h2>
                                    <p class="small text-muted">{{ $t('admin.directory.posts.subtitle') }}</p>
                                    <hr class="mt-0 mb-1">

                                    <div v-show="selectedPosts && selectedPosts.length !== 12" class="nav-wrapper">
                                        <ul class="nav nav-pills nav-fill flex-column flex-md-row" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link mb-sm-3 mb-md-0 active" id="favposts-1-tab" data-toggle="tab" href="#favposts-1" role="tab" aria-controls="favposts-1" aria-selected="true">{{ $t('admin.directory.posts.selectedPosts', { count: this.selectedPosts.length ? this.selectedPosts.length : '' }) }}</a>
                                            </li>
                                            <li v-if="selectedPosts && selectedPosts.length < 12" class="nav-item">
                                                <a class="nav-link mb-sm-3 mb-md-0" id="favposts-2-tab" data-toggle="tab" href="#favposts-2" role="tab" aria-controls="favposts-2" aria-selected="false">{{ $t('admin.directory.posts.addById') }}</a>
                                            </li>
                                            <li v-if="selectedPosts && selectedPosts.length < 12" class="nav-item">
                                                <a class="nav-link mb-sm-3 mb-md-0" id="favposts-3-tab" data-toggle="tab" href="#favposts-3" role="tab" aria-controls="favposts-3" aria-selected="false" @click="initPopularPosts">{{ $t('admin.directory.posts.addByPopularity') }}</a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="tab-content mt-3">
                                        <div class="tab-pane fade list-fade-bottom show active" id="favposts-1" role="tabpanel" aria-labelledby="favposts-1-tab">
                                            <div v-if="selectedPosts && selectedPosts.length" style="max-height: 520px; overflow-y: auto;">
                                                <div
                                                    v-for="post in selectedPosts"
                                                    :key="'sp-' + post.id"
                                                    class="list-group-item border-primary form-control-muted"
                                                    >
                                                    <div class="media align-items-center">
                                                        <div class="custom-control custom-checkbox mr-2">
                                                            <input type="checkbox" class="custom-control-input" checked :id="`checkbox-sp-${post.id}`" @change="toggleSelectedPost(post)">
                                                            <label class="custom-control-label" :for="`checkbox-sp-${post.id}`"></label>
                                                        </div>

                                                        <img :src="post.media_attachments[0].url" class="border rounded-sm mr-3" width="100" height="100" style="object-fit: cover;" loading="lazy">

                                                        <div class="media-body">
                                                            <p class="lead mt-0 mb-0 font-weight-bold">&commat;{{ post.account.username }}</p>
                                                            <p class="text-muted mb-0" style="font-size: 14px;">
                                                                <i18n path="admin.directory.posts.likesCount" tag="span"><template v-slot:count><span class="font-weight-bold">{{ formatCount(post.favourites_count) }}</span></template></i18n>
                                                                <span class="mx-2">·</span>
                                                                <i18n path="admin.directory.posts.followersCount" tag="span"><template v-slot:count><span class="font-weight-bold">{{ formatCount(post.account.followers_count) }}</span></template></i18n>
                                                                <span class="mx-2">·</span>
                                                                <i18n path="admin.directory.posts.createdAt" tag="span"><template v-slot:date><span class="font-weight-bold">{{ formatDateTime(post.created_at) }}</span></template></i18n>
                                                            </p>
                                                        </div>

                                                        <a class="btn btn-outline-primary btn-sm rounded-pill" :href="post.url" target="_blank">{{ $t('admin.directory.posts.view') }}</a>
                                                    </div>
                                                </div>

                                                <div class="mt-5 mb-5 pt-3"></div>
                                            </div>

                                            <div v-else>
                                                <div class="card card-body bg-lighter text-center py-5">
                                                    <p class="text-light mb-1"><i class="far fa-info-circle fa-3x"></i></p>
                                                    <p class="h2 mb-0">{{ $t('admin.directory.posts.noneSelected') }}</p>

                                                    <p class="small mb-0">{{ $t('admin.directory.posts.selectUpTo') }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="favposts-2" role="tabpanel" aria-labelledby="favposts-2-tab">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">{{ $t('admin.directory.posts.findById') }}</label>
                                                        <div class="input-group mb-3">
                                                            <input
                                                                type="number"
                                                                class="form-control form-control-muted border"
                                                                :placeholder="$t('admin.directory.posts.postId')"
                                                                min="1"
                                                                max="99999999999999999999"
                                                                v-model="favouritePostByIdInput"
                                                                :disabled="favouritePostByIdFetching">
                                                            <div class="input-group-append">
                                                                <button v-if="!favouritePostByIdFetching" class="btn btn-outline-primary" type="button" @click="handlePostByIdSearch">
                                                                    {{ $t('admin.directory.posts.search') }}
                                                                </button>
                                                                <button v-else class="btn btn-outline-primary" disabled>
                                                                    <div class="spinner-border spinner-border-sm" role="status">
                                                                        <span class="sr-only">{{ $t('common.loading') }}</span>
                                                                    </div>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="card card-body bg-primary">
                                                        <div class="d-flex align-items-center text-white">
                                                            <i class="far fa-info-circle mr-2"></i>
                                                            <p class="small mb-0 font-weight-bold">{{ $t('admin.directory.posts.postIdHelp') }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade list-fade-bottom mb-0" id="favposts-3" role="tabpanel" aria-labelledby="favposts-3-tab">
                                            <div v-if="popularPostsLoaded" class="list-group" style="max-height: 520px; overflow-y: auto;">
                                                <div
                                                    v-for="post in popularPosts"
                                                    :key="'pp-' + post.id"
                                                    class="list-group-item"
                                                    :class="[ selectedPosts.includes(post) ? 'border-primary form-control-muted': '' ]">
                                                    <div class="media align-items-center">
                                                        <div class="custom-control custom-checkbox mr-2">
                                                            <input type="checkbox" class="custom-control-input" :id="`checkbox-pp-${post.id}`" @change="togglePopularPost(post.id, post)" :checked="selectedPosts.includes(post)">
                                                            <label class="custom-control-label" :for="`checkbox-pp-${post.id}`"></label>
                                                        </div>

                                                        <img :src="post.media_attachments[0].url" class="border rounded-sm mr-3" width="100" height="100" style="object-fit: cover;" loading="lazy">
                                                        <div class="media-body">
                                                            <p class="lead mt-0 mb-0 font-weight-bold">&commat;{{ post.account.username }}</p>
                                                            <p class="text-muted mb-0" style="font-size: 14px;">
                                                                <i18n path="admin.directory.posts.likesCount" tag="span"><template v-slot:count><span class="font-weight-bold">{{ formatCount(post.favourites_count) }}</span></template></i18n>
                                                                <span class="mx-2">·</span>
                                                                <i18n path="admin.directory.posts.followersCount" tag="span"><template v-slot:count><span class="font-weight-bold">{{ formatCount(post.account.followers_count) }}</span></template></i18n>
                                                                <span class="mx-2">·</span>
                                                                <i18n path="admin.directory.posts.createdAt" tag="span"><template v-slot:date><span class="font-weight-bold">{{ formatDateTime(post.created_at) }}</span></template></i18n>
                                                            </p>
                                                        </div>

                                                        <a class="btn btn-outline-primary btn-sm rounded-pill" :href="post.url" target="_blank">{{ $t('admin.directory.posts.view') }}</a>
                                                    </div>
                                                </div>
                                                <div class="mt-5 mb-3"></div>
                                            </div>
                                            <div v-else class="text-center py-5">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="sr-only">{{ $t('common.loading') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div v-else-if="tabIndex === 6" class="tab-pane fade show active" role="tabpanel">
                                    <h2 class="display-4 mb-0">{{ $t('admin.directory.tabs.privacyPledge') }}</h2>
                                    <p class="small text-muted">{{ $t('admin.directory.pledge.subtitle') }}</p>
                                    <hr class="mt-0">

                                    <p>{{ $t('admin.directory.pledge.intro') }}</p>
                                    <ul class="font-weight-bold">
                                        <li>{{ $t('admin.directory.pledge.rule1') }}</li>
                                        <li>{{ $t('admin.directory.pledge.rule2') }}</li>
                                        <li>{{ $t('admin.directory.pledge.rule3') }}</li>
                                        <li>{{ $t('admin.directory.pledge.rule4') }}</li>
                                        <li>{{ $t('admin.directory.pledge.rule5') }}</li>
                                        <li>{{ $t('admin.directory.pledge.rule6') }}</li>
                                    </ul>
                                    <p class="small text-muted mb-0">{{ $t('admin.directory.pledge.footnote') }}</p>
                                    <hr>

                                    <p>
                                        <div class="custom-control custom-checkbox mr-2">
                                            <input type="checkbox" class="custom-control-input" id="privacy-pledge" v-model="form.privacy_pledge">
                                            <label class="custom-control-label font-weight-bold" for="privacy-pledge">{{ $t('admin.directory.pledge.agree') }}</label>
                                        </div>
                                    </p>
                                </div>

                                <div v-else-if="tabIndex === 7" class="tab-pane fade show active" role="tabpanel">
                                    <h2 class="display-4 mb-0">{{ $t('admin.directory.tabs.communityGuidelines') }}</h2>
                                    <p class="small text-muted">{{ $t('admin.directory.guidelines.subtitle') }}</p>
                                    <hr class="mt-0">

                                    <ol v-if="communityGuidelines && communityGuidelines.length" class="font-weight-bold">
                                        <li v-for="rule in communityGuidelines" class="text-primary"><span class="lead ml-1 text-dark">{{ rule }}</span></li>
                                    </ol>

                                    <div v-else class="card bg-primary text-white">
                                        <div class="card-body text-center py-5">
                                            <p class="mb-n3"><i class="far fa-exclamation-circle fa-3x"></i></p>
                                            <p class="lead mb-0">{{ $t('admin.directory.guidelines.empty') }}</p>
                                        </div>
                                    </div>

                                    <hr>

                                    <i18n path="admin.directory.guidelines.manage" tag="p" class="mb-0">
                                        <template v-slot:link><a href="/i/admin/settings">{{ $t('admin.directory.guidelines.settingsPage') }}</a></template>
                                    </i18n>
                                </div>

                                <div v-else-if="tabIndex === 8" class="tab-pane fade show active" role="tabpanel">
                                    <h2 class="display-4 mb-0">{{ $t('admin.directory.tabs.featureRequirements') }}</h2>
                                    <p class="small text-muted">{{ $t('admin.directory.features.subtitle') }}</p>
                                    <hr class="mt-0">

                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="list-group">
                                                <div class="list-group-item d-flex align-items-center">
                                                    <div>
                                                        <i
                                                            class="far fa-2x mr-4"
                                                            :class="[
                                                                !requirements_validator.hasOwnProperty('media_types') ?
                                                                'fa-check-circle text-success' :
                                                                'fa-exclamation-circle text-danger'
                                                            ]">
                                                        </i>
                                                    </div>
                                                    <div>
                                                        <p class="font-weight-bold text-dark my-0">{{ $t('admin.directory.features.mediaTypes') }}</p>
                                                        <p class="mb-0 small text-muted">{{ $t('admin.directory.features.mediaTypesHelp') }}</p>
                                                        <p v-if="requirements_validator.hasOwnProperty('media_types')" class="mb-0 text-danger font-weight-bold">{{ requirements_validator.media_types[0] }}</p>
                                                    </div>
                                                </div>

                                                <div v-if="feature_config.optimize_image" class="list-group-item d-flex align-items-center">
                                                    <div>
                                                        <i
                                                            class="far fa-2x mr-4"
                                                            :class="[
                                                                !requirements_validator.hasOwnProperty('image_quality') ?
                                                                'fa-check-circle text-success' :
                                                                'fa-exclamation-circle text-danger'
                                                            ]">
                                                        </i>
                                                    </div>
                                                    <div>
                                                        <p class="font-weight-bold text-dark my-0">{{ $t('admin.directory.features.imageQuality') }}</p>
                                                        <p class="mb-0 small text-muted">{{ $t('admin.directory.features.imageQualityHelp') }}</p>
                                                        <p v-if="requirements_validator.hasOwnProperty('image_quality')" class="mb-0 text-danger font-weight-bold">{{ requirements_validator.image_quality[0] }}</p>
                                                    </div>
                                                </div>

                                                <div class="list-group-item d-flex align-items-center">
                                                    <div>
                                                        <i
                                                            class="far fa-2x mr-4"
                                                            :class="[
                                                                !requirements_validator.hasOwnProperty('max_photo_size') ?
                                                                'fa-check-circle text-success' :
                                                                'fa-exclamation-circle text-danger'
                                                            ]">
                                                        </i>
                                                    </div>
                                                    <div>
                                                        <p class="font-weight-bold text-dark my-0">{{ $t('admin.directory.features.maxPhotoSize') }}</p>
                                                        <p class="mb-0 small text-muted">{{ $t('admin.directory.features.maxPhotoSizeHelp') }}</p>
                                                        <p v-if="requirements_validator.hasOwnProperty('max_photo_size')" class="mb-0 text-danger font-weight-bold">{{ requirements_validator.max_photo_size[0] }}</p>
                                                    </div>
                                                </div>

                                                <div class="list-group-item d-flex align-items-center">
                                                    <div>
                                                        <i
                                                            class="far fa-2x mr-4"
                                                            :class="[
                                                                !requirements_validator.hasOwnProperty('max_caption_length') ?
                                                                'fa-check-circle text-success' :
                                                                'fa-exclamation-circle text-danger'
                                                            ]">
                                                        </i>
                                                    </div>
                                                    <div>
                                                        <p class="font-weight-bold text-dark my-0">{{ $t('admin.directory.features.maxCaptionLength') }}</p>
                                                        <p class="mb-0 small text-muted">{{ $t('admin.directory.features.maxCaptionLengthHelp') }}</p>
                                                        <p v-if="requirements_validator.hasOwnProperty('max_caption_length')" class="mb-0 text-danger font-weight-bold">{{ requirements_validator.max_caption_length[0] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="list-group">
                                                <div class="list-group-item d-flex align-items-center">
                                                    <div>
                                                        <i
                                                            class="far fa-2x mr-4"
                                                            :class="[
                                                                !requirements_validator.hasOwnProperty('max_altext_length') ?
                                                                'fa-check-circle text-success' :
                                                                'fa-exclamation-circle text-danger'
                                                            ]">
                                                        </i>
                                                    </div>
                                                    <div>
                                                        <p class="font-weight-bold text-dark my-0">{{ $t('admin.directory.features.maxAltTextLength') }}</p>
                                                        <p class="mb-0 small text-muted">{{ $t('admin.directory.features.maxAltTextLengthHelp') }}</p>
                                                        <p v-if="requirements_validator.hasOwnProperty('max_altext_length')" class="mb-0 text-danger font-weight-bold">{{ requirements_validator.max_altext_length[0] }}</p>
                                                    </div>
                                                </div>

                                                <div v-if="feature_config.enforce_account_limit" class="list-group-item d-flex align-items-center">
                                                    <div>
                                                        <i
                                                            class="far fa-2x mr-4"
                                                            :class="[
                                                                !requirements_validator.hasOwnProperty('max_account_size') ?
                                                                'fa-check-circle text-success' :
                                                                'fa-exclamation-circle text-danger'
                                                            ]">
                                                        </i>
                                                    </div>
                                                    <div>
                                                        <p class="font-weight-bold text-dark my-0">{{ $t('admin.directory.features.maxAccountSize') }}</p>
                                                        <p class="mb-0 small text-muted">{{ $t('admin.directory.features.maxAccountSizeHelp') }}</p>
                                                        <p v-if="requirements_validator.hasOwnProperty('max_account_size')" class="mb-0 text-danger font-weight-bold">{{ requirements_validator.max_account_size[0] }}</p>
                                                    </div>
                                                </div>

                                                <div class="list-group-item d-flex align-items-center">
                                                    <div>
                                                        <i
                                                            class="far fa-2x mr-4"
                                                            :class="[
                                                                !requirements_validator.hasOwnProperty('max_album_length') ?
                                                                'fa-check-circle text-success' :
                                                                'fa-exclamation-circle text-danger'
                                                            ]">
                                                        </i>
                                                    </div>
                                                    <div>
                                                        <p class="font-weight-bold text-dark my-0">{{ $t('admin.directory.features.maxAlbumLength') }}</p>
                                                        <p class="mb-0 small text-muted">{{ $t('admin.directory.features.maxAlbumLengthHelp') }}</p>
                                                        <p v-if="requirements_validator.hasOwnProperty('max_album_length')" class="mb-0 text-danger font-weight-bold">{{ requirements_validator.max_album_length[0] }}</p>
                                                    </div>
                                                </div>

                                                <div class="list-group-item d-flex align-items-center">
                                                    <div>
                                                        <i
                                                            class="far fa-2x mr-4"
                                                            :class="[
                                                                !requirements_validator.hasOwnProperty('account_deletion') ?
                                                                'fa-check-circle text-success' :
                                                                'fa-exclamation-circle text-danger'
                                                            ]">
                                                        </i>
                                                    </div>
                                                    <div>
                                                        <p class="font-weight-bold text-dark my-0">{{ $t('admin.directory.features.accountDeletion') }}</p>
                                                        <p class="mb-0 small text-muted">{{ $t('admin.directory.features.accountDeletionHelp') }}</p>
                                                        <p v-if="requirements_validator.hasOwnProperty('account_deletion')" class="mb-0 text-danger font-weight-bold">{{ requirements_validator.account_deletion[0] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div v-else-if="tabIndex === 9" class="tab-pane fade show active" role="tabpanel">
                                    <h2 class="display-4 mb-0">{{ $t('admin.directory.tabs.testimonials') }}</h2>
                                    <p class="small text-muted">{{ $t('admin.directory.testimonials.subtitle') }}</p>
                                    <hr class="mt-0">

                                    <div class="row">
                                        <div class="col-12 col-md-6 list-fade-bottom">
                                            <div class="list-group pb-5" style="max-height: 520px; overflow-y: auto;">
                                                <div
                                                    v-for="(testimonial, idx) in testimonials"
                                                    class="list-group-item"
                                                    :class="[ idx == (testimonials.length - 1) ? 'mb-5' : '' ]">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="media">
                                                            <img :src="testimonial.profile.avatar" class="mr-3 rounded-circle" width="40" h="40">
                                                            <div class="media-body">
                                                                <p class="font-weight-bold mb-0">
                                                                    {{ testimonial.profile.username }}
                                                                </p>
                                                                <p class="small text-muted mt-n1 mb-0">
                                                                    {{ $t('admin.directory.testimonials.memberSince', { date: formatDate(testimonial.profile.created_at) }) }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <p class="mb-0 small">
                                                                <a
                                                                    href="#"
                                                                    @click.prevent="editTestimonial(testimonial)">
                                                                    {{ $t('admin.directory.testimonials.edit') }}
                                                                </a>
                                                            </p>
                                                            <p class="mb-0 small">
                                                                <a
                                                                    href="#"
                                                                    class="text-danger"
                                                                    @click.prevent="deleteTestimonial(testimonial)">
                                                                    {{ $t('common.delete') }}
                                                                </a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <hr class="my-1">
                                                    <p class="small font-weight-bold text-muted mb-0 text-center">{{ $t('admin.directory.testimonials.testimonial') }}</p>
                                                    <div class="border rounded px-3">
                                                        <p v-html="testimonial.body" class="my-2 small" style="white-space: pre-wrap;"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div v-if="isEditingTestimonial" class="card">
                                                <div class="card-header font-weight-bold">
                                                    {{ $t('admin.directory.testimonials.editTitle') }}
                                                </div>

                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="form-summary" class="font-weight-bold">{{ $t('admin.directory.testimonials.username') }}</label>
                                                        <input
                                                            class="form-control form-control-muted"
                                                            placeholder="test"
                                                            v-model="editingTestimonial.profile.username"
                                                            disabled />
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="form-summary" class="font-weight-bold">{{ $t('admin.directory.testimonials.testimonial') }}</label>
                                                        <textarea
                                                            class="form-control form-control-muted"
                                                            rows="5"
                                                            v-model="editingTestimonial.body"></textarea>
                                                        <div class="d-flex justify-content-between">
                                                            <p class="help-text small text-muted mb-0">
                                                                {{ $t('admin.directory.testimonials.textOnly') }}
                                                            </p>
                                                            <p class="help-text small text-muted mb-0">
                                                                {{ editingTestimonial.body ? editingTestimonial.body.length : 0 }}/500
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card-footer">
                                                    <button
                                                        type="button"
                                                        class="btn btn-primary btn-block"
                                                        @click="saveEditTestimonial">
                                                        {{ $t('admin.directory.testimonials.save') }}
                                                    </button>

                                                    <button
                                                        type="button"
                                                        class="btn btn-secondary btn-block"
                                                        @click="cancelEditTestimonial">
                                                        {{ $t('common.cancel') }}
                                                    </button>
                                                </div>
                                            </div>

                                            <div v-else class="card">
                                                <template v-if="testimonials.length < 10">
                                                    <div class="card-header font-weight-bold">
                                                        {{ $t('admin.directory.testimonials.addTitle') }}
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="form-summary" class="font-weight-bold">{{ $t('admin.directory.testimonials.username') }}</label>
                                                            <input
                                                                class="form-control form-control-muted"
                                                                placeholder="test"
                                                                v-model="testimonial.username" />
                                                            <p class="help-text small text-muted">
                                                                {{ $t('admin.directory.testimonials.validUser') }}
                                                            </p>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="form-summary" class="font-weight-bold">{{ $t('admin.directory.testimonials.testimonial') }}</label>
                                                            <textarea
                                                                class="form-control form-control-muted"
                                                                rows="5"
                                                                v-model="testimonial.body"></textarea>
                                                            <div class="d-flex justify-content-between">
                                                                <p class="help-text small text-muted mb-0">
                                                                    {{ $t('admin.directory.testimonials.textOnly') }}
                                                                </p>
                                                                <p class="help-text small text-muted mb-0">
                                                                    {{ testimonial.body ? testimonial.body.length : 0 }}/500
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card-footer">
                                                        <button
                                                            type="button"
                                                            class="btn btn-primary btn-block"
                                                            @click="saveTestimonial">{{ $t('admin.directory.testimonials.saveTestimonial') }}</button>
                                                    </div>
                                                </template>
                                                <template v-else>
                                                    <div class="card-body text-center">
                                                        <p class="lead">{{ $t('admin.directory.testimonials.limitReached') }}</p>
                                                    </div>
                                                </template>
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
    export default {
        data() {
            return {
                loaded: false,
                initialData: {},
                tabIndex: 1,
                tabs: [
                    // `title` holds a translation key, rendered with $t() in the template
                    { id: 1, title: "admin.directory.tabs.overview", icon: "far fa-home" },
                    // { id: 2, title: "Status", icon: "far fa-asterisk" },
                    { id: 3, title: "admin.directory.tabs.serverDetails", icon: "far fa-info-circle" },
                    { id: 4, title: "admin.directory.tabs.adminContact", icon: "far fa-user-crown" },
                    { id: 5, title: "admin.directory.tabs.favouritePosts", icon: "far fa-heart" },
                    { id: 6, title: "admin.directory.tabs.privacyPledge", icon: "far fa-eye-slash" },
                    { id: 7, title: "admin.directory.tabs.communityGuidelines", icon: "far fa-smile-beam" },
                    { id: 8, title: "admin.directory.tabs.featureRequirements", icon: "far fa-bolt" },
                    { id: 9, title: "admin.directory.tabs.testimonials", icon: "far fa-comment-smile"}
                ],

                form: {
                    summary: "",
                    location: 0,
                    contact_account: 0,
                    contact_email: "",
                    privacy_pledge: undefined,
                    banner_image: undefined,
                    locale: 0
                },

                requirements: {
                    activitypub_enabled: undefined,
                    open_registration: undefined,
                    oauth_enabled: undefined,
                    curated_onboarding: undefined,
                },
                feature_config: [],
                requirements_validator: [],

                popularPostsLoaded: false,
                popularPosts: [],
                selectedPopularPosts: [],
                selectedPosts: [],
                favouritePostByIdInput: "",
                favouritePostByIdFetching: false,
                communityGuidelines: [],
                isUploadingBanner: false,

                state: {
                    is_eligible: false,
                    submission_exists: false,
                    awaiting_approval: false,
                    is_active: false,
                    submission_timestamp: undefined,
                },

                isSubmitting: false,

                testimonial: {
                    username: undefined,
                    body: undefined
                },

                testimonials: [],
                isEditingTestimonial: false,
                editingTestimonial: undefined,
            }
        },

        mounted() {
            this.fetchInitialData();
        },

        methods: {
            toggleTab(idx) {
                this.tabIndex = idx;
            },

            fetchInitialData() {
                axios.get('/i/admin/api/directory/initial-data')
                .then(res => {
                    this.initialData = res.data;

                    if(res.data.activitypub_enabled) {
                        this.requirements.activitypub_enabled = res.data.activitypub_enabled;
                    }

                    if(res.data.open_registration) {
                        this.requirements.open_registration = res.data.open_registration;
                    }

                    if(res.data.curated_onboarding) {
                        this.requirements.curated_onboarding = res.data.curated_onboarding;
                    }

                    if(res.data.oauth_enabled) {
                        this.requirements.oauth_enabled = res.data.oauth_enabled;
                    }

                    if(res.data.summary) {
                        this.form.summary = res.data.summary;
                    }

                    if(res.data.location) {
                        this.form.location = res.data.location;
                    }

                    if(res.data.favourite_posts) {
                        this.selectedPosts = res.data.favourite_posts;
                    }

                    if(res.data.admin) {
                        this.form.contact_account = res.data.admin;
                    }

                    if(res.data.contact_email) {
                        this.form.contact_email = res.data.contact_email;
                    }

                    if(res.data.community_guidelines) {
                        this.communityGuidelines = res.data.community_guidelines;
                    }

                    if(res.data.privacy_pledge) {
                        this.form.privacy_pledge = res.data.privacy_pledge;
                    }

                    if(res.data.feature_config) {
                        this.feature_config = res.data.feature_config;
                    }

                    if(res.data.requirements_validator) {
                        this.requirements_validator = res.data.requirements_validator;
                    }

                    if(res.data.banner_image) {
                        this.form.banner_image = res.data.banner_image;
                    }

                    if(res.data.primary_locale) {
                        this.form.primary_locale = res.data.primary_locale;
                    }

                    if(res.data.is_eligible) {
                        this.state.is_eligible = res.data.is_eligible;
                    }

                    if(res.data.testimonials) {
                        this.testimonials = res.data.testimonials;
                    }

                    if(res.data.submission_state) {
                        this.state.is_active = res.data.submission_state.active_submission;
                        this.state.submission_exists = res.data.submission_state.pending_submission;
                        this.state.awaiting_approval = res.data.submission_state.pending_submission;
                    }
                })
                .then(() => {
                    this.loaded = true;
                })
            },

            initPopularPosts() {
                if(this.popularPostsLoaded) {
                    return;
                }

                axios.get('/i/admin/api/directory/popular-posts')
                .then(res => {
                    this.popularPosts = res.data.filter(pp => !this.selectedPosts.map(sp => sp.id).includes(pp.id));
                })
                .then(() => {
                    this.popularPostsLoaded = true;
                })
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

            togglePopularPost(id, post) {
                if(!this.selectedPosts.length) {
                    this.selectedPosts.push(post);
                    return;
                }
                const exists = this.selectedPosts.map(sp => sp.id).includes(id);
                if(exists) {
                    this.selectedPosts = this.selectedPosts.filter(i => i.id != id);
                } else {
                    if(this.selectedPosts.length >= 12) {
                        swal(this.$t('common.oops'), this.$t('admin.directory.posts.limitPopular'), 'error');
                        event.currentTarget.checked = false;
                        return;
                    }
                    this.selectedPosts.push(post);
                }
            },

            toggleSelectedPost(post) {
                this.selectedPosts = this.selectedPosts.filter(i => i.id !== post.id);
            },

            handlePostByIdSearch() {
                event.currentTarget.blur();
                if(this.selectedPosts.length >= 12) {
                    swal(this.$t('common.oops'), this.$t('admin.directory.posts.limit'), 'error');
                    return;
                }
                this.favouritePostByIdFetching = true;

                axios.post('/i/admin/api/directory/add-by-id', {
                    q: this.favouritePostByIdInput
                })
                .then(res => {
                    if(this.selectedPosts.map(p => p.id).includes(res.data.id)) {
                        swal(this.$t('common.oops'), this.$t('admin.directory.posts.alreadySelected'), 'error');
                        return;
                    }
                    this.selectedPosts.push(res.data);
                    this.favouritePostByIdInput = "";
                    this.popularPosts = this.popularPosts.filter(pp => pp.id != res.data.id);
                })
                .then(() => {
                    this.favouritePostByIdFetching = false;
                    $('#favposts-1-tab').tab('show');
                })
                .catch(err => {
                    swal(this.$t('admin.directory.posts.invalidPost'), this.$t('admin.directory.posts.invalidPostBody'), 'error');
                    this.favouritePostByIdFetching = false;
                })
            },

            save() {
                axios.post('/i/admin/api/directory/save', {
                    'location': this.form.location,
                    'summary': this.form.summary,
                    'admin_uid': this.form.contact_account,
                    'contact_email': this.form.contact_email,
                    'favourite_posts': this.selectedPosts.map(p => p.id),
                    'privacy_pledge': this.form.privacy_pledge
                })
                .then(res => {
                    swal(this.$t('admin.directory.successTitle'), this.$t('admin.directory.saved'), 'success');
                })
                .catch(err => {
                    swal(this.$t('common.oops'), err.response.data.message, 'error');
                })
            },

            uploadBannerImage() {
                this.isUploadingBanner = true;

                if(!window.confirm(this.$t('admin.directory.confirmUpdateBanner'))) {
                    this.isUploadingBanner = false;
                    return;
                }

                let formData = new FormData();
                formData.append('banner_image', this.$refs.bannerImageRef.files[0]);

                axios.post('/i/admin/api/directory/save',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(res => {
                    this.form.banner_image = res.data.banner_image;
                    this.isUploadingBanner = false;
                })
                .catch(err => {
                    swal(this.$t('common.error'), err.response.data.message, 'error');
                    this.isUploadingBanner = false;
                })
            },

            deleteBannerImage() {
                if(!window.confirm(this.$t('admin.directory.confirmDeleteBanner'))) {
                    return;
                }

                axios.delete('/i/admin/api/directory/banner-image')
                .then(res => {
                    this.form.banner_image = res.data;
                })
                .catch(err => {
                    console.log(err);
                })
            },

            handleSubmit() {
                if(!window.confirm(this.$t('admin.directory.confirmSubmit'))) {
                    return;
                }

                this.isSubmitting = true;
                axios.post('/i/admin/api/directory/submit')
                .then(res => {
                    setTimeout(() => {
                        this.isSubmitting = false;
                        // this.state.awaiting_approval = true;
                        this.state.is_active = true;
                        console.log(res.data);
                    }, 3000);
                })
                .catch(err => {
                    swal(this.$t('common.error'), err.response.data.message, 'error');
                })
            },

            deleteTestimonial(testimonial) {
                if(!window.confirm(this.$t('admin.directory.testimonials.confirmDelete', { username: testimonial.profile.username }))) {
                    return;
                }

                axios.post('/i/admin/api/directory/testimonial/delete', {
                    profile_id: testimonial.profile.id
                })
                .then(res => {
                    this.testimonials = this.testimonials.filter(t => {
                        return t.profile.id != testimonial.profile.id
                    })
                })
            },

            editTestimonial(testimonial) {
                this.isEditingTestimonial = true;
                this.editingTestimonial = testimonial;
            },

            saveTestimonial() {
                event.currentTarget?.blur();

                axios.post('/i/admin/api/directory/testimonial/save', {
                    username: this.testimonial.username,
                    body: this.testimonial.body
                })
                .then(res => {
                    this.testimonials.push(res.data);
                    this.testimonial = {
                        username: undefined,
                        body: undefined
                    }
                })
                .catch(err => {
                    let msg = err.response.data.hasOwnProperty('error') ? err.response.data.error :
                    err.response.data.message;
                    swal(this.$t('common.oops'), msg, 'error');
                })
            },

            cancelEditTestimonial() {
                event.currentTarget?.blur();
                this.isEditingTestimonial = false;
                this.editingTestimonial = {};
            },

            saveEditTestimonial() {
                event.currentTarget?.blur();
                axios.post('/i/admin/api/directory/testimonial/update', {
                    profile_id: this.editingTestimonial.profile.id,
                    body: this.editingTestimonial.body
                })
                .then(res => {
                    this.isEditingTestimonial = false;
                    this.editingTestimonial = {};
                })

            }
        },

        watch: {
            selectedPosts: function(posts) {
                let ids = posts.map(p => p.id);
                this.popularPosts = this.popularPosts.filter(pp => !ids.includes(pp.id));
            },
        }
    }
</script>
