@extends('settings.template')

@section('section')

  <div class="title">
    <h3 class="font-weight-bold">{{ __('settings.notifications.notification_settings') }}</h3>
  </div>
  <hr>
  <div class="alert alert-danger">
    {{ __('settings.notifications.coming_soon') }}
  </div>

@endsection