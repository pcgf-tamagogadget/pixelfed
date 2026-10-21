@extends('site.help.partial.template', ['breadcrumb'=>__('helpcenter.directMessages')])

@section('section')

<div class="title">
  <h3 class="font-weight-bold">{{__('helpcenter.directMessages')}}</h3>
</div>
<hr>
<p class="lead ">{{ __('helpcenter.dm.intro') }}</p>
<hr>
<p>
  <a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse1" role="button" aria-expanded="false" aria-controls="collapse1">
    <i class="fas fa-chevron-down mr-2"></i>
    {{ __('helpcenter.dm.q1') }}
  </a>
  <div class="collapse" id="collapse1">
    <div>
      <p>{{ __('helpcenter.dm.a1Intro') }}</p>
      <ul>
        <li>
          {{ __('helpcenter.dm.a1Item1') }}
        </li>
        <li>
          {{ __('helpcenter.dm.a1Item2') }}
        </li>
        <li>
          {{ __('helpcenter.dm.a1Item3') }}
        </li>
        <li>
          {{ __('helpcenter.dm.a1Item4') }}
        </li>
        <li>
          {{ __('helpcenter.dm.a1Item5') }}
        </li>
        <li>
          {{ __('helpcenter.dm.a1Item6') }}
        </li>
      </ul>
      <p>{!! __('helpcenter.dm.a1Manage') !!}</p>
      <p>{{ __('helpcenter.dm.a1Sharing') }}</p>
    </div>
  </div>
</p>
{{-- <p> 
  <a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse2" role="button" aria-expanded="false" aria-controls="collapse2">
    <i class="fas fa-chevron-down mr-2"></i>
    How do I manage messages I've recieved with Pixelfed Direct?
  </a>
  <div class="collapse" id="collapse2">
    <div>
      
    </div>
  </div>
</p> --}}
<p> 
  <a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse3" role="button" aria-expanded="false" aria-controls="collapse3">
    <i class="fas fa-chevron-down mr-2"></i>
    {{ __('helpcenter.dm.q3') }}
  </a>
  <div class="collapse" id="collapse3">
    <div class="mt-2">
      {!! __('helpcenter.dm.a3') !!}
    </div>
  </div>
</p>
<p> 
  <a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse4" role="button" aria-expanded="false" aria-controls="collapse4">
    <i class="fas fa-chevron-down mr-2"></i>
    {{ __('helpcenter.dm.q4') }}
  </a>
  <div class="collapse" id="collapse4">
    <div class="mt-2">
      {{ __('helpcenter.dm.a4') }}
    </div>
  </div>
</p>
<p> 
  <a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse5" role="button" aria-expanded="false" aria-controls="collapse5">
    <i class="fas fa-chevron-down mr-2"></i>
    {{ __('helpcenter.dm.q5') }}
  </a>
  <div class="collapse" id="collapse5">
    <div class="mt-2">
      {!! __('helpcenter.dm.a5') !!}
    </div>
  </div>
</p>

@endsection
