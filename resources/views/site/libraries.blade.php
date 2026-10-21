@extends('site.partial.template')

@section('section')

  <div class="title">
    <h3 class="font-weight-bold">{{ __('site.libraries.title') }}</h3>
  </div>
  <hr>
@endsection

@push('meta')
<meta property="og:description" content="{{ __('site.libraries.title') }}">
@endpush
