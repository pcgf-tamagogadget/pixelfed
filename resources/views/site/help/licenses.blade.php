@extends('site.help.partial.template', ['breadcrumb'=>__('helpcenter.licenses.title')])

@section('section')
  <div class="title">
    <h3 class="font-weight-bold">{{ __('helpcenter.licenses.title') }}</h3>
  </div>
  <hr>

  <p class="lead">
  	{{ __('helpcenter.licenses.p1') }}
  </p>
  <p class="lead">
  	{{ __('helpcenter.licenses.p2') }}
  </p>

  <p>{!! __('helpcenter.licenses.moreInfo') !!}</p>
@endsection
