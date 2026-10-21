@extends('site.help.partial.template', ['breadcrumb'=>__('helpcenter.yourProfile.title')])

@section('section')


  <div class="title">
    <h3 class="font-weight-bold">{{ __('helpcenter.yourProfile.title') }}</h3>
  </div>
  <hr>
  <p class="h5 text-muted ">{{ __('helpcenter.yourProfile.editSection') }}</p>
  <p>
    <a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse1" role="button" aria-expanded="false" aria-controls="collapse1">
      <i class="fas fa-chevron-down mr-2"></i>
      {{ __('helpcenter.yourProfile.q1') }}
    </a>
    <div class="collapse" id="collapse1">
      <div>
        {{ __('helpcenter.yourProfile.a1Intro') }}
        <ol class="">
          <li>{!! __('helpcenter.yourProfile.goTo', ['url' => e(route('settings'))]) !!}</li>
          <li>{!! __('helpcenter.yourProfile.a1Step2') !!}</li>
          <li>{!! __('helpcenter.yourProfile.a1Step3') !!}</li>
        </ol>
      </div>
    </div>
  </p>
  <p> 
    <a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse2" role="button" aria-expanded="false" aria-controls="collapse2">
      <i class="fas fa-chevron-down mr-2"></i>
      {{ __('helpcenter.yourProfile.q2') }}
    </a>
    <div class="collapse" id="collapse2">
      <div>
        {!! __('helpcenter.yourProfile.a2') !!}
      </div>
    </div>
  </p>
  <hr>
  <p class="h5 text-muted ">{{ __('helpcenter.yourProfile.privacySection') }}</p>
  <p> 
    <a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse3" role="button" aria-expanded="false" aria-controls="collapse3">
      <i class="fas fa-chevron-down mr-2"></i>
      {{ __('helpcenter.yourProfile.q3') }}
    </a>
    <div class="collapse" id="collapse3">
      <div>
        {{ __('helpcenter.yourProfile.a3Intro') }}
        <ol class="">
          <li>{!! __('helpcenter.yourProfile.goTo', ['url' => e(route('settings.privacy'))]) !!}</li>
          <li>{!! __('helpcenter.yourProfile.a3Step2') !!}</li>
          <li>{{ __('helpcenter.yourProfile.a3Step3') }}</li>
          <li>{!! __('helpcenter.yourProfile.a3Step4') !!}</li>
        </ol>
      </div>
    </div>
  </p>
  {{-- <p> 
    <a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse4" role="button" aria-expanded="false" aria-controls="collapse4">
      <i class="fas fa-chevron-down mr-2"></i>
      Who can like, share or comment on my photos and videos?
    </a>
    <div class="collapse" id="collapse4">
      <div>
        It depends on the visibility of your post.
      </div>
    </div>
  </p> --}}
  {{-- <p> 
    <a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse5" role="button" aria-expanded="false" aria-controls="collapse5">
      <i class="fas fa-chevron-down mr-2"></i>
      How do I filter out comments that I don't want to appear on my posts?
    </a>
    <div class="collapse" id="collapse5">
      <div>

      </div>
    </div>
  </p> --}}  
  {{-- <p> 
    <a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse6" role="button" aria-expanded="false" aria-controls="collapse6">
      <i class="fas fa-chevron-down mr-2"></i>
      Who can see my posts?
    </a>
    <div class="collapse" id="collapse6">
      <div>
        You can update your account by visiting the <a href="{{route('settings')}}">account settings</a> page.
      </div>
    </div>
  </p> --}}
  {{-- <p> 
    <a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse7" role="button" aria-expanded="false" aria-controls="collapse7">
      <i class="fas fa-chevron-down mr-2"></i>
      Who can see my private posts if I add a hashtag?
    </a>
    <div class="collapse" id="collapse7">
      <div>
        You can update your account by visiting the <a href="{{route('settings')}}">account settings</a> page.
      </div>
    </div>
  </p> --}}
  <hr>
  <p class="h5 text-muted " id="security">{{ __('helpcenter.yourProfile.securitySection') }}</p>
  <p> 
    <a class="text-dark font-weight-bold" data-toggle="collapse" href="#sec-collapse8" role="button" aria-expanded="false" aria-controls="sec-collapse8">
      <i class="fas fa-chevron-down mr-2"></i>
      {{ __('helpcenter.yourProfile.q8') }}
    </a>
    <div class="collapse" id="sec-collapse8">
      <div>
        {{ __('helpcenter.yourProfile.a8Intro') }}
        <ul class="">
          <li>{{ __('helpcenter.yourProfile.a8Item1') }}</li>
          <li>{{ __('helpcenter.yourProfile.a8Item2') }}</li>
          <li>{{ __('helpcenter.yourProfile.a8Item3') }}</li>
          <li>{!! __('helpcenter.yourProfile.a8Item4', ['url' => e(route('settings.security'))]) !!}</li>
          <li>{!! __('helpcenter.yourProfile.a8Item5', ['url' => e(route('settings.security.2fa.setup'))]) !!}</li>
        </ul>
      </div>
    </div>
  </p>
  <p> 
    <a class="text-dark font-weight-bold" data-toggle="collapse" href="#sec-collapse9" role="button" aria-expanded="false" aria-controls="sec-collapse9">
      <i class="fas fa-chevron-down mr-2"></i>
      {{ __('helpcenter.yourProfile.q9') }}
    </a>
    <div class="collapse" id="sec-collapse9">
      <div>
        {!! __('helpcenter.yourProfile.a9', ['url' => e(route('settings.security'))]) !!}
      </div>
    </div>
  </p>
  <p> 
    <a class="text-dark font-weight-bold" data-toggle="collapse" href="#sec-collapse10" role="button" aria-expanded="false" aria-controls="sec-collapse10">
      <i class="fas fa-chevron-down mr-2"></i>
      {{ __('helpcenter.yourProfile.q10') }}
    </a>
    <div class="collapse" id="sec-collapse10">
      <div>
        {{ __('helpcenter.yourProfile.a10') }}
      </div>
    </div>
  </p>
  <hr>
  <p class="h5 text-muted " id="migration">{{ __('helpcenter.yourProfile.migrationSection') }}</p>
  <p>
    <a class="text-dark font-weight-bold" data-toggle="collapse" href="#migrate-collapse1" role="button" aria-expanded="false" aria-controls="migrate-collapse1">
      <i class="fas fa-chevron-down mr-2"></i>
      {{ __('helpcenter.yourProfile.mq1') }}
    </a>
    <div class="collapse" id="migrate-collapse1">
      <div>
        {!! __('helpcenter.yourProfile.ma1') !!}
        <hr>
        <p>{!! __('helpcenter.yourProfile.ma1Aliases') !!}</p>
      </div>
    </div>
  </p>
  <p>
    <a class="text-dark font-weight-bold" data-toggle="collapse" href="#migrate-collapse2" role="button" aria-expanded="false" aria-controls="migrate-collapse2">
      <i class="fas fa-chevron-down mr-2"></i>
      {{ __('helpcenter.yourProfile.mq2') }}
    </a>
    <div class="collapse" id="migrate-collapse2">
      <div>
        {{ __('helpcenter.yourProfile.ma2') }}
      </div>
    </div>
  </p>
  <p>
    <a class="text-dark font-weight-bold" data-toggle="collapse" href="#migrate-collapse3" role="button" aria-expanded="false" aria-controls="migrate-collapse3">
      <i class="fas fa-chevron-down mr-2"></i>
      {{ __('helpcenter.yourProfile.mq3') }}
    </a>
    <div class="collapse" id="migrate-collapse3">
      <div>
        {{ __('helpcenter.yourProfile.ma3') }}
        <hr>
        {{ __('helpcenter.yourProfile.ma2') }}
      </div>
    </div>
  </p>
  <hr>
  <p class="h5 text-muted " id="delete-your-account">{{ __('helpcenter.yourProfile.deleteSection') }}</p>
  <p> 
    <a class="text-dark font-weight-bold" data-toggle="collapse" href="#del-collapse1" role="button" aria-expanded="false" aria-controls="del-collapse1">
      <i class="fas fa-chevron-down mr-2"></i>
      {{ __('helpcenter.yourProfile.dq1') }}
    </a>
    <div class="collapse" id="del-collapse1">
      <div>
        <p>{{ __('helpcenter.yourProfile.da1Intro') }}</p>
        <ol class="">
          <li>{!! __('helpcenter.yourProfile.da1Step1', ['url' => e(config('app.url')), 'domain' => e(config('pixelfed.domain.app'))]) !!}</li>
          <li>{!! __('helpcenter.yourProfile.da1Step2') !!}</li>
          <li>{!! __('helpcenter.yourProfile.securitySettingsStep', ['url' => e(route('settings.security'))]) !!}</li>
          <li>{{ __('helpcenter.yourProfile.confirmPassword') }}</li>
          <li>{!! __('helpcenter.yourProfile.da1Step5') !!}</li>
          <li>{{ __('helpcenter.yourProfile.followInstructions') }}</li>
        </ol>
      </div>
    </div>
  </p>
  @if(config('pixelfed.account_deletion'))
  <p> 
    <a class="text-dark font-weight-bold" data-toggle="collapse" href="#del-collapse2" role="button" aria-expanded="false" aria-controls="del-collapse2">
      <i class="fas fa-chevron-down mr-2"></i>
      {{ __('helpcenter.yourProfile.dq2') }}
    </a>
    <div class="collapse" id="del-collapse2">
      <div>
        @if(config('pixelfed.account_delete_after') == false)
        <div class="bg-light p-3 mb-4">
          <p class="mb-0">{!! __('helpcenter.yourProfile.da2Warning', ['url' => e(route('settings.remove.temporary'))]) !!}</p>
        </div>
        @else
        <div class="bg-light p-3 mb-4">
          <p class="mb-0">{!! __('helpcenter.yourProfile.da2WarningDelayed', ['days' => e(config('pixelfed.account_delete_after')), 'url' => e(route('settings.remove.temporary'))]) !!}</p>
        </div>
        @endif
        <p>{{ __('helpcenter.yourProfile.da2After') }}</p>
        <p>{{ __('helpcenter.yourProfile.da2Intro') }}</p>
        <ol class="">
          <li>{!! __('helpcenter.yourProfile.da2Step1', ['url' => e(route('settings.remove.permanent'))]) !!}</li>
          <li>{!! __('helpcenter.yourProfile.securitySettingsStep', ['url' => e(route('settings.security'))]) !!}</li>
          <li>{{ __('helpcenter.yourProfile.confirmPassword') }}</li>
          <li>{!! __('helpcenter.yourProfile.da2Step4') !!}</li>
          <li>{{ __('helpcenter.yourProfile.followInstructions') }}</li>
        </ol>
      </div>
    </div>
  </p>
  @endif
@endsection
