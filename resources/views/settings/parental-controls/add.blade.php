@extends('settings.template-vue')

@section('section')
<form class="d-flex h-100 flex-column" method="post">
    @csrf
<div class="d-flex h-100 flex-column">
    <div class="d-flex justify-content-between align-items-center">
        <div class="title d-flex align-items-center" style="gap: 1rem;">
            <p class="mb-0"><a href="/settings/parental-controls"><i class="far fa-chevron-left fa-lg"></i></a></p>
            <h3 class="font-weight-bold mb-0">{{ __('settings.parental_controls.add_child') }}</h3>
        </div>
    </div>

    <hr />

    <div class="d-flex flex-column flex-grow-1">
        <h4>{{ __('settings.parental_controls.choose_your_childs_policies') }}</h4>

        <div class="mb-4">
            <p class="font-weight-bold mb-1">{{ __('settings.parental_controls.allowed_actions') }}</p>

            @include('settings.parental-controls.checkbox', ['name' => 'post', 'title' => __('settings.parental_controls.post'), 'checked' => true])
            @include('settings.parental-controls.checkbox', ['name' => 'comment', 'title' => __('settings.parental_controls.comment'), 'checked' => true])
            @include('settings.parental-controls.checkbox', ['name' => 'like', 'title' => __('settings.parental_controls.like'), 'checked' => true])
            @include('settings.parental-controls.checkbox', ['name' => 'share', 'title' => __('settings.parental_controls.share'), 'checked' => true])
            @include('settings.parental-controls.checkbox', ['name' => 'follow', 'title' => __('settings.parental_controls.follow')])
            @include('settings.parental-controls.checkbox', ['name' => 'bookmark', 'title' => __('settings.parental_controls.bookmark')])
            @include('settings.parental-controls.checkbox', ['name' => 'story', 'title' => __('settings.parental_controls.add_to_story')])
            @include('settings.parental-controls.checkbox', ['name' => 'collection', 'title' => __('settings.parental_controls.add_to_collection')])
        </div>
        <div class="mb-4">
            <p class="font-weight-bold mb-1">{{ __('settings.parental_controls.enabled_features') }}</p>

            @include('settings.parental-controls.checkbox', ['name' => 'discovery_feeds', 'title' => __('settings.parental_controls.discovery_feeds')])
            @include('settings.parental-controls.checkbox', ['name' => 'dms', 'title' => __('settings.parental_controls.direct_messages')])
            @include('settings.parental-controls.checkbox', ['name' => 'federation', 'title' => __('settings.parental_controls.federation')])
        </div>
        <div class="mb-4">
            <p class="font-weight-bold mb-1">{{ __('settings.parental_controls.preferences') }}</p>

            @include('settings.parental-controls.checkbox', ['name' => 'hide_network', 'title' => __('settings.parental_controls.hide_my_childs_connections')])
            @include('settings.parental-controls.checkbox', ['name' => 'private', 'title' => __('settings.parental_controls.make_my_childs_account_private')])
            @include('settings.parental-controls.checkbox', ['name' => 'hide_cw', 'title' => __('settings.parental_controls.hide_sensitive_media')])
        </div>
    </div>

    <div>
        <div class="form-group">
            <label class="font-weight-bold mb-0">{{ __('settings.parental_controls.email_address') }}</label>
            <p class="help-text lh-1 small">{{ __('settings.parental_controls.where_should_we_send_this_invite') }}</p>
            <input class="form-control" placeholder="{{ __('settings.parental_controls.enter_your_childs_email_address') }}" name="email" required>
        </div>

        <button class="btn btn-dark btn-block font-weight-bold">{{ __('settings.parental_controls.add_child_button') }}</button>
    </div>
</div>
</form>
@endsection

