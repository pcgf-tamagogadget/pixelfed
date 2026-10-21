@extends('site.help.partial.template', ['breadcrumb'=>__('helpcenter.communityGuidelines')])

@section('section')

  <div class="title">
    <h3 class="font-weight-bold">{{ __('helpcenter.communityGuidelines') }}</h3>
  </div>
  <hr>
  @if($page)
  <div>
    {!!$page['content']!!}
    <hr>
    <p class="">{{ __('helpcenter.communityGuidelinesPage.lastUpdated', ['date' => $page['created_at']]) }}</p>
  </div>
  @else
  <div>
    <p class="lead mb-5">{{ __('helpcenter.communityGuidelinesPage.intro', ['domain' => config('pixelfed.domain.app')]) }}</p>
    <div class="py-4">
      <h5 class="pb-3">{{ __('helpcenter.communityGuidelinesPage.removedTitle') }}</h5>
      <ul>
        <li class="mb-3">{{ __('helpcenter.communityGuidelinesPage.removed1') }}</li>
        <li class="mb-3">{{ __('helpcenter.communityGuidelinesPage.removed2') }}</li>
        <li class="mb-3">{{ __('helpcenter.communityGuidelinesPage.removed3') }}</li>
        <li class="mb-3">{{ __('helpcenter.communityGuidelinesPage.removed4') }}</li>
      </ul>
    </div>
    <hr>
    <div class="py-4">
      <h5 class="pb-3">{{ __('helpcenter.communityGuidelinesPage.suspensionTitle') }}</h5>
      <ul>
        <li class="mb-3">{{ __('helpcenter.communityGuidelinesPage.suspension1') }}</li>
        <li class="mb-3">{{ __('helpcenter.communityGuidelinesPage.suspension2') }}</li>
        <li class="mb-3">{{ __('helpcenter.communityGuidelinesPage.suspension3') }}</li>
        <li class="mb-3">{{ __('helpcenter.communityGuidelinesPage.suspension4') }}</li>
      </ul>
    </div>
    <hr>
    <div class="py-4">
      <h5 class="pb-3">{{ __('helpcenter.communityGuidelinesPage.disallowedTitle') }}</h5>
      <ul>
        <li class="mb-3">{{ __('helpcenter.communityGuidelinesPage.disallowed1') }}</li>
        <li class="mb-3">{{ __('helpcenter.communityGuidelinesPage.disallowed2') }}</li>
        <li class="mb-3">{{ __('helpcenter.communityGuidelinesPage.disallowed3') }}</li>
      </ul>
    </div>
    <hr>
    <div class="py-4">
      <h5 class="pb-3">{{ __('helpcenter.communityGuidelinesPage.harassmentTitle') }}</h5>
      <ul>
        <li class="mb-3">{{ __('helpcenter.communityGuidelinesPage.harassment1') }}</li>
        <li class="mb-3">{{ __('helpcenter.communityGuidelinesPage.harassment2') }}</li>
        <li class="mb-3">{{ __('helpcenter.communityGuidelinesPage.harassment3') }}</li>
      </ul>
    </div>
    <hr>
    <p>{{ __('helpcenter.communityGuidelinesPage.reserveRight') }}</p>
    <hr>
    <p class="">{{ __('helpcenter.communityGuidelinesPage.lastUpdated', ['date' => 'Jun 26, 2019']) }}</p>
    <p class="">{!! __('helpcenter.communityGuidelinesPage.adaptedFrom') !!}</p>
</div>
  @endif
@endsection
