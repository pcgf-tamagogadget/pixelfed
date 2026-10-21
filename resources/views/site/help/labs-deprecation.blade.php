@extends('site.help.partial.template', ['breadcrumb'=>__('helpcenter.labsDeprecation.title')])

@section('section')

  <div class="title">
    <h3 class="font-weight-bold">{{ __('helpcenter.labsDeprecation.title') }}</h3>
  </div>
  <hr>
  <p class="lead">{{ __('helpcenter.labsDeprecation.intro') }}</p>
  <hr>
  <h4 class="font-weight-bold">{{ __('helpcenter.labsDeprecation.q1') }}</h4>
  <p>{{ __('helpcenter.labsDeprecation.a1') }}</p>
  <hr>
  <h4 class="font-weight-bold">{{ __('helpcenter.labsDeprecation.q2') }}</h4>
  <p>{{ __('helpcenter.labsDeprecation.a2') }}</p>
  <hr>
  <h4 class="font-weight-bold">{{ __('helpcenter.labsDeprecation.q3') }}</h4>
  <p>{{ __('helpcenter.labsDeprecation.a3') }}</p>
  <hr>
  <p class="small">{{ __('helpcenter.labsDeprecation.lastUpdated') }}</p>
@endsection