@extends('layouts.app')

@section('content')
@php
  // Translate the built-in defaults; keep admin-customized (env) text as-is.
  $errHeader = config('instance.page.503.header');
  $errBody = config('instance.page.503.body');
  if ($errHeader === __('pages.errors.unavailable', [], 'en-US')) { $errHeader = e(__('pages.errors.unavailable')); }
  if ($errBody === __('pages.errors.unavailableBody', [], 'en-US')) { $errBody = __('pages.errors.unavailableBody'); }
@endphp
<div class="container">
  <div class="error-page py-5 my-5 text-center">
    <h3 class="font-weight-bold">{!! $errHeader !!}</h3>
    <p class="lead">{!! $errBody !!}</p>
  </div>
</div>
@endsection
