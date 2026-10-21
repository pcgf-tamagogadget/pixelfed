@extends('site.help.partial.template', ['breadcrumb'=>__('helpcenter.timelines')])

@section('section')

	<div class="title">
		<h3 class="font-weight-bold">{{ __('helpcenter.timelines') }}</h3>
	</div>
	<hr>
	<p class="lead">{{ __('helpcenter.timelinesPage.intro') }}</p>
	{{-- <p class="font-weight-bold h5 py-3">Pixelfed has 3 different timelines:</p> --}}

	<ul class="list-unstyled">
		<li class="lead mb-2">
			<span class="font-weight-bold"><i class="fas fa-home mr-2"></i> {{ __('helpcenter.timelinesPage.home') }}</span>
			<span class="px-2">&mdash;</span>
			<span class="font-weight-light">{{ __('helpcenter.timelinesPage.homeDesc') }}</span>
		</li>
		<li class="lead mb-2">
			<span class="font-weight-bold"><i class="fas fa-stream mr-2"></i> {{ __('helpcenter.timelinesPage.public') }}</span>
			<span class="px-2">&mdash;</span>
			<span class="font-weight-light">{{ __('helpcenter.timelinesPage.publicDesc') }}</span>
		</li>
		<li class="lead">
			<span class="font-weight-bold"><i class="fas fa-globe mr-2"></i> {{ __('helpcenter.timelinesPage.network') }}</span>
			<span class="px-2">&mdash;</span>
			<span class="font-weight-light">{{ __('helpcenter.timelinesPage.networkDesc') }}</span>
		</li>
	</ul>
	<div class="py-3"></div>
	<div class="card bg-primary border-primary" style="box-shadow: none !important;border: 3px solid #08d!important;">
		<div class="card-header text-light font-weight-bold h4 p-4 bg-primary">{{ __('helpcenter.timelinesPage.tipsTitle') }}</div>
		<div class="card-body bg-white p-3">
			<ul class="pt-3">
				<li class="lead mb-4">{{ __('helpcenter.timelinesPage.tip1') }}</li>
				<li class="lead mb-4">{!! __('helpcenter.timelinesPage.tip2') !!}</li>

			</ul>
		</div>
	</div>
@endsection
