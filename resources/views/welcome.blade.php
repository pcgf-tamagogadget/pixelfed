@extends('layouts.app')

@section('content')
    <div class="jumbotron jumbotron-fluid bg-pixelfed text-white my-0">
      <div class="container text-center my-5 py-5">
        <h1 class="display-4">{{ __('pages.welcome.tagline') }}</h1>
        <p class="lead">{!! __('pages.welcome.poweredBy', ['activitypub' => '<a href="https://en.wikipedia.org/wiki/ActivityPub" class="text-white font-weight-bold">ActivityPub</a>', 'fediverse' => '<a href="https://en.wikipedia.org/wiki/Fediverse" class="text-white font-weight-bold">'.e(__('pages.welcome.fediverse')).'</a>']) !!}</p>
      </div>
    </div>
@endsection

@push('meta')
<meta property="og:description" content="{{ __('pages.welcome.tagline') }}">
@endpush
