@extends('site.help.partial.template', ['breadcrumb'=>__('helpcenter.import.title')])

@section('section')

    <div class="title">
        <h3 class="font-weight-bold">{{ __('helpcenter.import.title') }}</h3>
    </div>
    <hr>
    <p class="lead py-3">{{ __('helpcenter.import.intro') }}</p>

    <hr class="mb-4" />

    <p class="text-center font-weight-bold">{{ __('helpcenter.import.howToTitle') }}</p>
    <ol class="pb-4">
        <li class="mb-2">
            <span>{!! __('helpcenter.import.step1') !!}</span>
        </li>
        <li class="mb-2">
            <span>{{ __('helpcenter.import.step2') }}</span>
        </li>
        <li class="mb-2">
            <span>{{ __('helpcenter.import.step3') }}</span>
        </li>
        <li class="mb-2">
            <span>{!! __('helpcenter.import.step4') !!}</span>
        </li>
        <li class="">
            <span>{{ __('helpcenter.import.step5') }}</span>
        </li>
    </ol>
    <hr class="mb-4" />

    <p class="text-center font-weight-bold">{{ __('helpcenter.import.limitsTitle') }}</p>

    <div class="list-group pb-4">
        <div class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <p class="font-weight-bold mb-0">{{ __('helpcenter.import.maxPosts') }}</p>
                <p class="small mb-0">{{ __('helpcenter.import.maxPostsDesc') }}</p>
            </div>
            <div class="font-weight-bold">{{ config('import.instagram.limits.max_posts') == -1 ? __('helpcenter.import.unlimited') : config('import.instagram.limits.max_posts') }}</div>
        </div>
        <div class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <p class="font-weight-bold mb-0">{{ __('helpcenter.import.maxAttempts') }}</p>
                <p class="small mb-0">{!! __('helpcenter.import.maxAttemptsDesc') !!}</p>
            </div>
            <div class="font-weight-bold">{{ config('import.instagram.limits.max_attempts') == -1 ? __('helpcenter.import.unlimited') : config('import.instagram.limits.max_attempts') }}</div>
        </div>
        <div class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <p class="font-weight-bold mb-0">{{ __('helpcenter.import.videoImports') }}</p>
                <p class="small mb-0">{{ __('helpcenter.import.videoImportsDesc') }}</p>
            </div>
            <div class="font-weight-bold">{{ config('import.instagram.allow_video_posts') ? '✅' : '❌' }}</div>
        </div>
    </div>

    <hr class="mb-4" />

    <p class="text-center font-weight-bold mb-0">{{ __('helpcenter.import.permissionsTitle') }}</p>
    <p class="text-center small">{{ __('helpcenter.import.permissionsDesc') }}</p>

    <div class="list-group">
        <div class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <p class="font-weight-bold mb-0">{{ __('helpcenter.import.onlyAdmins') }}</p>
                <p class="small mb-0">{{ __('helpcenter.import.onlyAdminsDesc') }}</p>
            </div>
            <div class="font-weight-bold">{{ config('import.instagram.permissions.admins_only') ? '✅' : '❌' }}</div>
        </div>
        <div class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <p class="font-weight-bold mb-0">{{ __('helpcenter.import.onlyAdminsFollowing') }}</p>
                <p class="small mb-0">{{ __('helpcenter.import.onlyAdminsFollowingDesc') }}</p>
            </div>
            <div class="font-weight-bold">{{ config('import.instagram.permissions.admin_follows_only') ? '✅' : '❌' }}</div>
        </div>
        <div class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <p class="font-weight-bold mb-0">{{ __('helpcenter.import.minAccountAge') }}</p>
                <p class="small mb-0">{{ __('helpcenter.import.minAccountAgeDesc') }}</p>
            </div>
            <div class="font-weight-bold">{{ config('import.instagram.permissions.min_account_age')}}</div>
        </div>
        <div class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <p class="font-weight-bold mb-0">{{ __('helpcenter.import.minFollowerCount') }}</p>
                <p class="small mb-0">{{ __('helpcenter.import.minFollowerCountDesc') }}</p>
            </div>
            <div class="font-weight-bold">{{ config('import.instagram.permissions.min_follower_count')}}</div>
        </div>
    </div>
@endsection
