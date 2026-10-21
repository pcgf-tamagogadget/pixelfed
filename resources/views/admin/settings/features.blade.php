@extends('admin.partial.template')

@include('admin.settings.sidebar')

@section('section')
  <div class="title">
    <h3 class="font-weight-bold">{{ __('admin_panel.settings.features.title') }}</h3>
    <p class="lead">{{ __('admin_panel.settings.features.subtitle') }}</p>
  </div>
  <hr>
  <p class="alert alert-warning">
    <strong>{{ __('admin_panel.common.featureUnavailable') }}</strong> {{ __('admin_panel.common.futureVersion') }}
  </p>
@endsection