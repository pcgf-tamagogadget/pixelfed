@extends('site.help.partial.template', ['breadcrumb'=>__('helpcenter.reportSomething')])

@section('section')

  <div class="title">
    <h3 class="font-weight-bold">{{ __('helpcenter.reportSomething') }}</h3>
  </div>
  <hr>
  <div class="card">
  	<div class="card-body">
  		<div class="row">
  			<div class="col-12 col-md-3 text-center">
  				<div class="icon-wrapper">
  					<i class="far fa-question-circle fa-3x text-light"></i>
  				</div>
  			</div>
  			<div class="col-12 col-md-9 d-flex align-items-center">
  				<div class="text-center">
	  				<p class="h3 font-weight-bold mb-0">{{ __('helpcenter.common.unavailableTitle') }}</p>
	  				<p class="font-weight-light mb-0">{{ __('helpcenter.common.unavailableBody') }}</p>
  				</div>
  			</div>
  		</div>
  	</div>
  </div>
@endsection
