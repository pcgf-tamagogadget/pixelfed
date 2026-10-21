@extends('site.help.partial.template', ['breadcrumb'=>__('helpcenter.sharingMediaPage.title')])

@section('section')

	<div class="title">
		<h3 class="font-weight-bold">{{ __('helpcenter.sharingMediaPage.title') }}</h3>
	</div>
	<hr>
	<p>
		<a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse1" role="button" aria-expanded="false" aria-controls="collapse1">
			<i class="fas fa-chevron-down mr-2"></i>
			{{ __('helpcenter.sharingMediaPage.q1') }}
		</a>
		<div class="collapse" id="collapse1">
			<div>
				{{ __('helpcenter.sharingMediaPage.a1Desktop') }}
				<ol>
					<li>{!! __('helpcenter.sharingMediaPage.goTo', ['url' => e(config('app.url'))]) !!}</li>
					<li>{!! __('helpcenter.sharingMediaPage.a1DesktopStep2') !!}</li>
					<li>{{ __('helpcenter.sharingMediaPage.uploadStep') }}</li>
					<li>{!! __('helpcenter.sharingMediaPage.createPostStep') !!}</li>
				</ol>
			</div>
			<div class="pt-3">
				{{ __('helpcenter.sharingMediaPage.a1Mobile') }}
				<ol>
					<li>{!! __('helpcenter.sharingMediaPage.goTo', ['url' => e(config('app.url'))]) !!}</li>
					<li>{!! __('helpcenter.sharingMediaPage.a1MobileStep2') !!}</li>
					<li>{{ __('helpcenter.sharingMediaPage.uploadStep') }}</li>
					<li>{!! __('helpcenter.sharingMediaPage.createPostStep') !!}</li>
				</ol>
			</div>
		</div>
	</p>
	<p>
		<a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse2" role="button" aria-expanded="false" aria-controls="collapse2">
			<i class="fas fa-chevron-down mr-2"></i>
			{{ __('helpcenter.sharingMediaPage.q2') }}
		</a>
		<div class="collapse" id="collapse2">
			<div>
				{{ __('helpcenter.sharingMediaPage.a2') }}
			</div>
		</div>
	</p>
	<p>
		<a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse3" role="button" aria-expanded="false" aria-controls="collapse3">
			<i class="fas fa-chevron-down mr-2"></i>
			{{ __('helpcenter.sharingMediaPage.q3') }}
		</a>
		<div class="collapse" id="collapse3">
			<div>
				{!! __('helpcenter.sharingMediaPage.a3', ['count' => e(config_cache('pixelfed.max_caption_length'))]) !!}
			</div>
		</div>
	</p>
	<p>
		<a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse4" role="button" aria-expanded="false" aria-controls="collapse4">
			<i class="fas fa-chevron-down mr-2"></i>
			{{ __('helpcenter.sharingMediaPage.q4') }}
		</a>
		<div class="collapse" id="collapse4">
			<div>
				<p class="text-center">
					<span class="alert alert-warning py-2 font-weight-bold">{{ __('helpcenter.sharingMediaPage.a4Warning') }}</span>
				</p>
				{{ __('helpcenter.sharingMediaPage.a4Intro') }}
				<ol>
					<li>
						{!! __('helpcenter.sharingMediaPage.a4Step1') !!}
					</li>
					<li>{!! __('helpcenter.sharingMediaPage.a4Step2') !!}</li>
				</ol>
			</div>
		</div>
	</p>
	<p>
		<a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse5" role="button" aria-expanded="false" aria-controls="collapse5">
			<i class="fas fa-chevron-down mr-2"></i>
			{{ __('helpcenter.sharingMediaPage.q5') }}
		</a>
		<div class="collapse" id="collapse5">
			<div>
				<p class="text-center">
					<span class="alert alert-warning py-2 font-weight-bold">{{ __('helpcenter.sharingMediaPage.a5Warning') }}</span>
				</p>
				<p>
					{!! __('helpcenter.sharingMediaPage.a5Intro') !!}
				</p>
				<ol>
					<li>{!! __('helpcenter.sharingMediaPage.a5Step1') !!}</li>
					<li>{!! __('helpcenter.sharingMediaPage.a5Step2') !!}</li>
				</ol>
				<p class="small text-muted"><i class="fas fa-info-circle mr-1"></i> {{ __('helpcenter.sharingMediaPage.a5Note') }}</p>
			</div>
		</div>
	</p>
	<p>
		<a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse6" role="button" aria-expanded="false" aria-controls="collapse6">
			<i class="fas fa-chevron-down mr-2"></i>
			{{ __('helpcenter.sharingMediaPage.q6') }}
		</a>
		<div class="collapse" id="collapse6">
			<div>
				{{ __('helpcenter.sharingMediaPage.a6') }}
				<ul>
					@foreach(explode(',', config_cache('pixelfed.media_types')) as $type)
					<li class="font-weight-bold">{{$type}}</li>
					@endforeach
				</ul>
			</div>
		</div>
	</p>
	{{-- <p>
		<a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse7" role="button" aria-expanded="false" aria-controls="collapse7">
			<i class="fas fa-chevron-down mr-2"></i>
			What is the limit for photo and video file sizes?
		</a>
		<div class="collapse" id="collapse7">
			<div>

			</div>
		</div>
	</p> --}}
	{{-- <p>
		<a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse8" role="button" aria-expanded="false" aria-controls="collapse8">
			<i class="fas fa-chevron-down mr-2"></i>
			When I share a photo, what's the image resolution?
		</a>
		<div class="collapse" id="collapse8">
			<div>

			</div>
		</div>
	</p> --}}
	{{-- <p>
		<a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse9" role="button" aria-expanded="false" aria-controls="collapse9">
			<i class="fas fa-chevron-down mr-2"></i>
			Can I edit my post captions, photos or videos after sharing them?
		</a>
		<div class="collapse" id="collapse9">
			<div>

			</div>
		</div>
	</p> --}}
	<p>
		<a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse10" role="button" aria-expanded="false" aria-controls="collapse10">
			<i class="fas fa-chevron-down mr-2"></i>
			{{ __('helpcenter.sharingMediaPage.q10') }}
		</a>
		<div class="collapse" id="collapse10">
			<div>
				{{ __('helpcenter.sharingMediaPage.a10Intro') }}
				<ul>
					<li>{!! __('helpcenter.sharingMediaPage.a10Step1') !!}</li>
					<li>{!! __('helpcenter.sharingMediaPage.a10Step2') !!}</li>
				</ul>
			</div>
		</div>
	</p>
	<p>
		<a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse11" role="button" aria-expanded="false" aria-controls="collapse11">
			<i class="fas fa-chevron-down mr-2"></i>
			{{ __('helpcenter.sharingMediaPage.q11') }}
		</a>
		<div class="collapse" id="collapse11">
			<div>
				{{ __('helpcenter.sharingMediaPage.a11') }}
			</div>
		</div>
	</p>

	<p>
		<a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse12" role="button" aria-expanded="false" aria-controls="collapse11">
			<i class="fas fa-chevron-down mr-2"></i>
			{{ __('helpcenter.sharingMediaPage.q12') }}
		</a>
		<div class="collapse" id="collapse12">
			<div>
				{{ __('helpcenter.sharingMediaPage.a12') }}
				<br />
				<strong class="text-danger">{{ __('helpcenter.sharingMediaPage.a12Warning') }}</strong>
				<br />
			</div>
		</div>
	</p>

	<p>
		<a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse13" role="button" aria-expanded="false" aria-controls="collapse11">
			<i class="fas fa-chevron-down mr-2"></i>
			{{ __('helpcenter.sharingMediaPage.q13') }}
		</a>
		<div class="collapse" id="collapse13">
			<div>
				{{ __('helpcenter.sharingMediaPage.a13Intro') }}
				<ul>
					<li>{{ __('helpcenter.sharingMediaPage.a13Step1') }}</li>
					<li>{!! __('helpcenter.sharingMediaPage.openMenuStep') !!}</li>
					<li>{!! __('helpcenter.sharingMediaPage.a13Step3') !!}</li>
				</ul>
			</div>
		</div>
	</p>

	<p>
		<a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse14" role="button" aria-expanded="false" aria-controls="collapse11">
			<i class="fas fa-chevron-down mr-2"></i>
			{{ __('helpcenter.sharingMediaPage.q14') }}
		</a>
		<div class="collapse" id="collapse14">
			<div>
				{{ __('helpcenter.sharingMediaPage.a14Intro') }}
				<ul>
					<li>{{ __('helpcenter.sharingMediaPage.a14Step1') }}</li>
					<li>{!! __('helpcenter.sharingMediaPage.a14Step2') !!}</li>
					<li>{{ __('helpcenter.sharingMediaPage.a14Step3') }}</li>
					<li>{!! __('helpcenter.sharingMediaPage.openMenuStep') !!}</li>
					<li>{!! __('helpcenter.sharingMediaPage.a14Step5') !!}</li>
				</ul>
			</div>
		</div>
	</p>

@endsection
