@extends('site.help.partial.template', ['breadcrumb'=>__('helpcenter.safetyTips')])

@section('section')

  <div class="title">
    <h3 class="font-weight-bold">{{ __('helpcenter.safetyTips') }}</h3>
  </div>
  <hr>
{{--   <div class="card mb-3">
  	<div class="card-body">
  		<div class="row">
  			<div class="col-12 col-md-3 text-center">
  				<div class="icon-wrapper">
  					<i class="fas fa-exclamation-circle fa-3x text-light"></i>
  				</div>
  			</div>
  			<div class="col-12 col-md-9 d-flex align-items-center">
  				<div class="text-center">
	  				<p class="h3 font-weight-bold mb-0">Work In Progress</p>
	  				<p class="font-weight-light mb-0">We haven't finished it yet, it will be updated soon!</p>
  				</div>
  			</div>
  		</div>
  	</div>
  </div>
 --}}
  <p class="lead py-4">{{ __('helpcenter.safetyTipsPage.intro') }}</p>

  <div class="card border-left-blue mb-3">
    <div class="card-body">
      <p class="h5">{{ __('helpcenter.safetyTipsPage.rulesTitle') }}</p>
      <p class="mb-0">{!! __('helpcenter.safetyTipsPage.rulesBody', ['url' => e(route('site.terms'))]) !!}</p>
    </div>
  </div>

  <div class="card border-left-blue mb-3">
    <div class="card-body">
      <p class="h5">{{ __('helpcenter.safetyTipsPage.ageTitle') }}</p>
      <p class="mb-0">{{ __('helpcenter.safetyTipsPage.ageBody', ['age' => (int) config('pixelfed.min_registration_age', 16)]) }}</p>
    </div>
  </div>

  <div class="card border-left-blue mb-3">
    <div class="card-body">
      <p class="h5">{{ __('helpcenter.safetyTipsPage.reportTitle') }}</p>
      <p class="mb-0">{{ __('helpcenter.safetyTipsPage.reportBody') }}</p>
    </div>
  </div>

  <div class="card border-left-blue mb-3">
    <div class="card-body">
      <p class="h5">{{ __('helpcenter.safetyTipsPage.visibilityTitle') }}</p>
      <p class="mb-0">{{ __('helpcenter.safetyTipsPage.visibilityBody') }}</p>
    </div>
  </div>


  <div class="card border-left-blue mb-3">
    <div class="card-body">
      <p class="h5">{{ __('helpcenter.safetyTipsPage.privateTitle') }}</p>
      <p class="mb-0">{{ __('helpcenter.safetyTipsPage.privateBody') }}</p>
    </div>
  </div>
@endsection
