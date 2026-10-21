@extends('settings.template')

@section('section')

  <div class="title">
    <h3 class="font-weight-bold">{{ __('settings.privacy.blocked_keywords_title') }}</h3>
  </div>
  <hr>
  <div class="form-group pb-1">
    <p>
      <a class="btn btn-outline-secondary py-0 font-weight-bold" href="{{route('settings.privacy.muted-users')}}">{{ __('settings.privacy.muted_users') }}</a>
      <a class="btn btn-outline-secondary py-0 font-weight-bold" href="{{route('settings.privacy.blocked-users')}}">{{ __('settings.privacy.blocked_users') }}</a>
      <a class="btn btn-outline-primary py-0 font-weight-bold" href="{{route('settings.privacy.blocked-keywords')}}">{{ __('settings.privacy.blocked_keywords') }}</a>
      <a class="btn btn-outline-secondary py-0 font-weight-bold" href="{{route('settings.privacy.blocked-instances')}}">{{ __('settings.privacy.blocked_instances') }}</a>
    </p>
  </div>
  <div class="alert alert-warning border-0">
    <p class="font-weight-bold mb-0">{{ __('settings.privacy.unavailable') }}</p>
    <p class="mb-0">{{ __('settings.privacy.this_setting_will_be_released_in_a_future_version') }}</p>
  </div>

@endsection