@extends('site.help.partial.template', ['breadcrumb'=>__('helpcenter.parentalControls.title')])

@section('section')
  <div class="title">
    <h3 class="font-weight-bold">{{ __('helpcenter.parentalControls.title') }}</h3>
  </div>
  <hr>

  <p>{{ __('helpcenter.parentalControls.intro') }}</p>

  <p class="font-weight-bold text-center">{{ __('helpcenter.parentalControls.keyFeatures') }}</p>

  <ul>
    <li>{!! __('helpcenter.parentalControls.feature1') !!}</li>
    <li>{!! __('helpcenter.parentalControls.feature2') !!}</li>
    <li>{!! __('helpcenter.parentalControls.feature3') !!}</li>
    <li>{!! __('helpcenter.parentalControls.feature4') !!}</li>
    <li>{!! __('helpcenter.parentalControls.feature5') !!}</li>
  </ul>
  <hr>

  <x-collapse :title="__('helpcenter.parentalControls.q1')">
    <div>
      @if(config('instance.parental_controls.enabled'))
      <ol>
        <li>{!! __('helpcenter.parentalControls.a1Step1') !!}</li>
        <li>{{ __('helpcenter.parentalControls.a1Step2') }}</li>
        <li>{{ __('helpcenter.parentalControls.a1Step3') }}</li>
        <li>{!! __('helpcenter.parentalControls.a1Step4') !!}</li>
        <li>{!! __('helpcenter.parentalControls.a1Step5') !!}</li>
        <li>{{ __('helpcenter.parentalControls.a1Step6') }}</li>
        <li>{!! __('helpcenter.parentalControls.a1Step7') !!}</li>
      </ol>
      @else
      <p>{{ __('helpcenter.parentalControls.disabled') }}</p>
      @endif
    </div>
  </x-collapse>

@if(config('instance.parental_controls.enabled'))
  <x-collapse :title="__('helpcenter.parentalControls.q2')">
    <div>
      {!! __('helpcenter.parentalControls.a2', ['count' => e(config('instance.parental_controls.limits.max_children'))]) !!}
    </div>
  </x-collapse>
@endif
@endsection
