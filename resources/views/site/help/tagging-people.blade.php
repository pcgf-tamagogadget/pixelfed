@extends('site.help.partial.template', ['breadcrumb'=>__('helpcenter.taggingPeople')])

@section('section')

  <div class="title">
    <h3 class="font-weight-bold">{{ __('helpcenter.taggingPeople') }}</h3>
  </div>
  <hr>
  <p class="lead">{{ __('helpcenter.taggingPeoplePage.intro') }}</p>
  <div class="py-4">
    <p class="font-weight-bold h5 pb-3">{{ __('helpcenter.taggingPeoplePage.inPostsTitle') }}</p>
    <ul>
      <li class="mb-3 ">{!! __('helpcenter.taggingPeoplePage.inPosts1') !!}</li>
      <li class="mb-3 ">{!! __('helpcenter.taggingPeoplePage.inPosts2') !!}</li>
    </ul>
  </div>
  <hr>
  <div class="card bg-primary border-primary" style="box-shadow: none !important;border: 3px solid #08d!important;">
    <div class="card-header text-light font-weight-bold h4 p-4 bg-primary">{{ __('helpcenter.taggingPeoplePage.tipsTitle') }}</div>
    <div class="card-body bg-white p-3">
      <ul class="pt-3">
        <li class="lead  mb-4">{{ __('helpcenter.taggingPeoplePage.tip1') }}</li>
        <li class="lead  mb-4">{{ __('helpcenter.taggingPeoplePage.tip2') }}</li>
        <li class="lead ">{{ __('helpcenter.taggingPeoplePage.tip3') }}</li>

      </ul>
    </div>
  </div>
@endsection