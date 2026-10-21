@extends('layouts.app')

@section('content')
@php
  // Translate the built-in defaults; keep admin-customized (env) text as-is.
  $errHeader = config('instance.page.404.header');
  $errBody = config('instance.page.404.body');
  if ($errHeader === __('pages.errors.notAvailable', [], 'en-US')) { $errHeader = e(__('pages.errors.notAvailable')); }
  if ($errBody === __('pages.errors.notAvailableBody', [], 'en-US')) { $errBody = __('pages.errors.notAvailableBody'); }
@endphp
<div class="container">
  <div class="error-page py-5 my-5 text-center">
    <h3 class="font-weight-bold">{!! $errHeader !!}</h3>
    <p class="lead">{!! $errBody !!}</p>
  </div>
</div>
@endsection
