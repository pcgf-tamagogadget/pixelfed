@extends('site.help.partial.template', ['breadcrumb'=>__('helpcenter.discover')])

@section('section')

  <div class="title">
    <h3 class="font-weight-bold">{{ __('helpcenter.discover') }}</h3>
  </div>
  <hr>
  <p class="lead">{{ __('helpcenter.discoverPage.intro') }}</p>
  <div class="py-4">
    <p class="font-weight-bold h5 pb-3">{{ __('helpcenter.discoverPage.howToTitle') }}</p>
    <ul>
      <li class="mb-3 ">{!! __('helpcenter.discoverPage.clickIcon') !!}</li>
      <li class="mb-3 ">{{ __('helpcenter.discoverPage.viewLatest') }}</li>
    </ul>
  </div>
  <div class="py-4">
    <p class="font-weight-bold h5 pb-3">{{ __('helpcenter.discoverPage.categoriesTitle') }} <span class="badge badge-success">{{ __('helpcenter.discoverPage.new') }}</span></p>
    <p>{{ __('helpcenter.discoverPage.categoriesBody') }}</p>
    <ul>
      <li class="mb-3 ">{!! __('helpcenter.discoverPage.clickIcon') !!}</li>
      <li class="mb-3 ">{{ __('helpcenter.discoverPage.categoryCards') }}</li>
    </ul>
  </div>
  <div class="card bg-primary border-primary" style="box-shadow: none !important;border: 3px solid #08d!important;">
    <div class="card-header text-light font-weight-bold h4 p-4 bg-primary">{{ __('helpcenter.discoverPage.tipsTitle') }}</div>
    <div class="card-body bg-white p-3">
      <ul class="pt-3">
        <li class="lead  mb-4">{{ __('helpcenter.discoverPage.tip1') }}</li>
        <li class="lead  mb-4">{{ __('helpcenter.discoverPage.tip2') }}</li>

      </ul>
    </div>
  </div>
@endsection