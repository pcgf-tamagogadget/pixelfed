@extends('site.help.partial.template', ['breadcrumb'=>__('helpcenter.gettingStarted')])

@section('section')

<div class="title">
	<h3 class="font-weight-bold">{{__('helpcenter.gettingStarted')}}</h3>
</div>
<hr>
<p class="lead ">{{ __('helpcenter.gettingStartedPage.welcome') }}</p>
<hr>
<p>
	<a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse1" role="button" aria-expanded="false" aria-controls="collapse1">
		<i class="fas fa-chevron-down mr-2"></i>
		{{ __('helpcenter.gettingStartedPage.q1') }}
	</a>
	<div class="collapse" id="collapse1">
		<div>
			{{ __('helpcenter.gettingStartedPage.a1Intro') }}
			<ol>
				<li>{!! __('helpcenter.gettingStartedPage.a1Step1', ['url' => e(config('app.url'))]) !!}</li>
				<li>{{ __('helpcenter.gettingStartedPage.a1Step2') }}</li>
				<li>{{ __('helpcenter.gettingStartedPage.a1Step3') }}</li>
				@if(config_cache('pixelfed.enforce_email_verification') != true)
				<li>{{ __('helpcenter.gettingStartedPage.a1Step4') }}</li>
				@endif
			</ol>
		</div>
	</div>
</p>
<p>
	<a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse2" role="button" aria-expanded="false" aria-controls="collapse2">
		<i class="fas fa-chevron-down mr-2"></i>
		{{ __('helpcenter.gettingStartedPage.q2') }}
	</a>
	<div class="collapse" id="collapse2">
		<div>
			{!! __('helpcenter.gettingStartedPage.a2', ['url' => e(route('settings'))]) !!}
		</div>
	</div>
</p>
<p>
	<a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse3" role="button" aria-expanded="false" aria-controls="collapse3">
		<i class="fas fa-chevron-down mr-2"></i>
		{{ __('helpcenter.gettingStartedPage.q3') }}
	</a>
	<div class="collapse" id="collapse3">
		<div class="mt-2">
			{{ __('helpcenter.gettingStartedPage.a3') }}
		</div>
	</div>
</p>
<p>
	<a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse4" role="button" aria-expanded="false" aria-controls="collapse4">
		<i class="fas fa-chevron-down mr-2"></i>
		{{ __('helpcenter.gettingStartedPage.q4') }}
	</a>
	<div class="collapse" id="collapse4">
		<div class="mt-2">
			{!! __('helpcenter.gettingStartedPage.a4') !!}
		</div>
	</div>
</p>
<p>
	<a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse5" role="button" aria-expanded="false" aria-controls="collapse5">
		<i class="fas fa-chevron-down mr-2"></i>
		{{ __('helpcenter.gettingStartedPage.q5') }}
	</a>
	<div class="collapse" id="collapse5">
		<div class="mt-2">
			{{ __('helpcenter.gettingStartedPage.a5') }}
		</div>
	</div>
</p>
<p>
	<a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse6" role="button" aria-expanded="false" aria-controls="collapse6">
		<i class="fas fa-chevron-down mr-2"></i>
		{{ __('helpcenter.gettingStartedPage.q6') }}
	</a>
	<div class="collapse" id="collapse6">
		<div class="mt-2">
			{{ __('helpcenter.gettingStartedPage.a6') }}
		</div>
	</div>
</p>

@endsection
