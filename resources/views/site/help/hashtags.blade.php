@extends('site.help.partial.template', ['breadcrumb'=>__('helpcenter.hashtags')])

@section('section')

  <div class="title">
    <h3 class="font-weight-bold">{{ __('helpcenter.hashtags') }}</h3>
  </div>
  <hr>
  <p class="lead">{{ __('helpcenter.hashtagsPage.intro') }}</p>
  <div class="py-4">
    <p class="font-weight-bold h5 pb-3">{{ __('helpcenter.hashtagsPage.usingTitle') }}</p>
    <ul>
      <li class="mb-3 ">{{ __('helpcenter.hashtagsPage.using1') }}</li>
      <li class="mb-3 ">{{ __('helpcenter.hashtagsPage.using2') }}</li>
      <li class="mb-3">{{ __('helpcenter.hashtagsPage.using3') }}</li>
      <li class="">{{ __('helpcenter.hashtagsPage.using4') }}</li>
    </ul>
  </div>
  <div class="py-4">
  <p>
    <a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse0" role="button" aria-expanded="false" aria-controls="collapse0">
      <i class="fas fa-chevron-down mr-2"></i>
      {{ __('helpcenter.hashtagsPage.q1') }}
    </a>
    <div class="collapse" id="collapse0">
      <div>
        <ul>
          <li>{{ __('helpcenter.hashtagsPage.a1Item1') }}</li>
          <li>{{ __('helpcenter.hashtagsPage.followIntro') }}</li>
        </ul>
      </div>
    </div>
  </p>
  <p>
    <a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse1" role="button" aria-expanded="false" aria-controls="collapse1">
      <i class="fas fa-chevron-down mr-2"></i>
      {{ __('helpcenter.hashtagsPage.q2') }}
    </a>
    <div class="collapse" id="collapse1">
      <div>
        <p>{{ __('helpcenter.hashtagsPage.followIntro') }}</p>
        <p class="mb-0">{{ __('helpcenter.hashtagsPage.toFollow') }}</p>
        <ol>
          <li>{{ __('helpcenter.hashtagsPage.followStep1') }}</li>
          <li>{!! __('helpcenter.hashtagsPage.followStep2') !!}</li>
        </ol>
        <p>{{ __('helpcenter.hashtagsPage.unfollow') }}</p>
        <p class="mb-0">
          {{ __('helpcenter.hashtagsPage.followLimit') }}
        </p>
      </div>
    </div>
  </p>
  </div>
  <hr>
  <div class="card bg-primary border-primary" style="box-shadow: none !important;border: 3px solid #08d!important;">
    <div class="card-header text-light font-weight-bold h4 p-4 bg-primary">{{ __('helpcenter.hashtagsPage.tipsTitle') }}</div>
    <div class="card-body bg-white p-3">
      <ul class="pt-3">
        <li class="lead  mb-4">{{ __('helpcenter.hashtagsPage.tip1') }}</li>
        <li class="lead  mb-4">{{ __('helpcenter.hashtagsPage.tip2') }}</li>
        <li class="lead ">{{ __('helpcenter.hashtagsPage.tip3') }}</li>

      </ul>
    </div>
  </div>
@endsection