@extends('layouts.app')

@section('content')
<div class="container">
  <div class="error-page py-5 my-5">
    <div class="card mx-5">
      <div class="card-body p-5 text-center">
        <h1>{{ __('site.closedRegistration.title') }}</h1>
        <p class="lead mb-0">{{ __('site.closedRegistration.body') }}</p>
        <hr>
        <p class="lead">{!! __('site.closedRegistration.findInstances') !!}</p>
      </div>
    </div>
  </div>
</div>
@endsection
