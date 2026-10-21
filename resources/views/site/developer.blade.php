@extends('site.partial.template')

@section('section')

  <div class="title">
    <h3 class="font-weight-bold">{{ __('site.developer.title') }}</h3>
  </div>
  <hr>
  <section>
    <p class="lead">{{ __('site.developer.intro') }}</p>
    <div class="row pt-5">
      <div class="col-12 col-md-6 pb-3">
        <div class="card">
          <div class="card-header font-weight-bold">CLASSIC API <span class="badge badge-primary">v1.0</span></div>
          <div class="card-body">
            <ul class="pl-2 font-weight-bold text-muted">
              <li>{{ __('site.developer.mastodonCompatible') }}</li>
              <li>{{ __('site.developer.oauthSupport') }}</li>
              <li>{{ __('site.developer.dashboard') }}</li>
              <li>{{ __('site.developer.tools') }}</li>
            </ul>
          </div>
          <div class="card-footer">
            <p class="font-weight-bold text-muted text-center mb-0">{{ __('site.developer.comingSoon') }}</p>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6 pb-3">
        <div class="card">
          <div class="card-header font-weight-bold">PIXELFED API <span class="badge badge-primary">v1.1</span></div>
          <div class="card-body">
            <ul class="pl-2 font-weight-bold text-muted">
              <li>Classic REST API</li>
              <li>Advanced Create API</li>
              <li>Discover API</li>
              <li>Stories API</li>
            </ul>
          </div>
          <div class="card-footer">
            <p class="font-weight-bold text-muted text-center mb-0">{{ __('site.developer.comingSoon') }}</p>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6">
        <div class="card">
          <div class="card-header font-weight-bold">{{ __('site.developer.other') }}</div>
          <div class="card-body">
            <ul class="pl-2 font-weight-bold text-muted mb-0">
              <li><a href="#">{{ __('site.developer.authentication') }}</a></li>
              <li><a href="#">{{ __('site.developer.clients') }}</a></li>
              <li><a href="#">{{ __('site.developer.rateLimiting') }}</a></li>
              <li><a href="#">{{ __('site.developer.activitypubEndpoints') }}</a></li>
              <li><a href="#">Atom/RSS Feeds</a></li>
              <li><a href="#">NodeInfo</a></li>
              <li><a href="#">Webfinger</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('meta')
<meta property="og:description" content="{{ __('site.developer.title') }}">
@endpush
