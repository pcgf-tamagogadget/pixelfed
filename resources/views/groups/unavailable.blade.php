@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center">
  <div class="error-page py-5 my-5" style="max-width: 450px;">
    <h3 class="font-weight-bold">{{ __('pages.groups.unavailable.title') }}</h3>
    <p class="lead">{{ __('pages.groups.unavailable.lead') }}</p>

    <div class="text-muted">
		<p class="pt-4 mb-1">{{ __('pages.groups.unavailable.reasons') }}</p>
		<ul>
			<li>{{ __('pages.groups.unavailable.invalidUrl') }}</li>
			<li>{{ __('pages.groups.unavailable.traffic') }}</li>
			<li>{{ __('pages.groups.unavailable.flagged') }}</li>
			<li>{{ __('pages.groups.unavailable.disabled') }}</li>
			<li>{{ __('pages.groups.unavailable.deleted') }}</li>
		</ul>

		<p class="pt-4">
			{!! __('pages.groups.unavailable.adminHint', ['link' => '<a href="#" class="font-weight-bold">'.e(__('pages.groups.unavailable.groupSettings')).'</a>']) !!}
		</p>
    </div>
  </div>
</div>
@endsection
