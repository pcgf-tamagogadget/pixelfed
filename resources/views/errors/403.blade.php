@extends('layouts.app')

@section('content')
<div class="container">
  <div class="error-page py-5 my-5 text-center">
    <h3 class="font-weight-bold">{{ __('pages.errors.notAvailable') }}</h3>
    <p class="lead">{!! __('pages.errors.notAvailableBody') !!}</p>
  </div>
</div>
@endsection
