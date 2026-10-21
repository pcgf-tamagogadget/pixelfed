@extends('site.help.partial.template', ['breadcrumb'=>__('helpcenter.instanceActor.title')])

@section('section')

  <div class="title">
    <h3 class="font-weight-bold">{{ __('helpcenter.instanceActor.title') }}</h3>
  </div>
  <hr>
  <p class="lead">{{ __('helpcenter.instanceActor.intro') }}</p>
  <div class="py-4">
    <p class="font-weight-bold h5 pb-3">{{ __('helpcenter.instanceActor.forAdmins') }}</p>
    <p class="mb-0">{{ __('helpcenter.instanceActor.forAdminsBody') }}</p>
  </div>
  <hr>
  <div class="card bg-primary border-primary" style="box-shadow: none !important;border: 3px solid #08d!important;">
    <div class="card-header text-light font-weight-bold h4 p-4 bg-primary">{{ __('helpcenter.instanceActor.tipsTitle') }}</div>
    <div class="card-body bg-white p-3">
      <ul class="pt-3">
        <li class="lead  mb-4">{{ __('helpcenter.instanceActor.tip1') }}</li>
        <li class="lead  mb-4">{{ __('helpcenter.instanceActor.tip2') }}</li>
        <li class="lead  mb-4">{{ __('helpcenter.instanceActor.tip3') }}</li>
        <li class="lead">{{ __('helpcenter.instanceActor.tip4') }}</li>
      </ul>
    </div>
  </div>
@endsection