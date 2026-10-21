@extends('site.help.partial.template', ['breadcrumb'=>__('helpcenter.curatedOnboarding.title')])

@section('section')
<div class="title">
    <h3 class="font-weight-bold">{{ __('helpcenter.curatedOnboarding.title') }}</h3>
</div>
<hr>
@if((bool) config_cache('instance.curated_registration.enabled') == false)
<div class="card bg-danger mb-3">
    <div class="card-body">
        @if((bool) config_cache('pixelfed.open_registration'))
        <p class="mb-0 text-white font-weight-bold">{{ __('helpcenter.curatedOnboarding.notAvailableOpen') }}</p>
        <hr>
        <p class="mb-0 text-center"><a href="/register" class="btn btn-light font-weight-bold rounded-pill">{{ __('helpcenter.curatedOnboarding.createAccount') }}</a></p>
        @else
        <p class="mb-0 text-white font-weight-bold">{{ __('helpcenter.curatedOnboarding.notAvailable') }}</p>
        @endif
    </div>
</div>
@endif
<p class="lead font-weight-bold">{{ __('helpcenter.curatedOnboarding.intro1') }}</p>
<p class="lead font-weight-light">{{ __('helpcenter.curatedOnboarding.intro2') }}</p>
<p class="lead font-weight-light">{{ __('helpcenter.curatedOnboarding.intro3') }}</p>
@if((bool) config_cache('instance.curated_registration.enabled') && !request()->user())
<p class="text-center pt-3">
    <a class="btn btn-outline-primary rounded-pill btn-lg font-weight-bold px-5" href="{{ route('auth.curated-onboarding') }}">{{ __('helpcenter.curatedOnboarding.applyToJoin') }} <i class="far fa-arrow-right ml-2"></i></a>
</p>
@endif
<hr class="my-5">
<h5 class="text-center text-muted font-weight-light my-5">{{ __('helpcenter.curatedOnboarding.howTitle') }}</h5>
<ol>
    <li>
        <p class="h5 font-weight-bold mb-2">{{ __('helpcenter.curatedOnboarding.step1Title') }}</p>
        <p style="font-size: 16px;line-height: 1.7;">{{ __('helpcenter.curatedOnboarding.step1Body') }}</p>
    </li>
    <hr class="my-5">
    <li>
        <p class="h5 font-weight-bold mb-2">{{ __('helpcenter.curatedOnboarding.step2Title') }}</p>
        <p style="font-size: 16px;line-height: 1.7;">{{ __('helpcenter.curatedOnboarding.step2Body') }}</p>
    </li>
    <hr class="my-5">
    <li>
        <p class="h5 font-weight-bold mb-2">{{ __('helpcenter.curatedOnboarding.step3Title') }}</p>
        <p style="font-size: 16px;line-height: 1.7;">{{ __('helpcenter.curatedOnboarding.step3Body') }}</p>
    </li>
</ol>
<hr class="my-5">
<h5 class="text-center text-muted font-weight-light my-5">{{ __('helpcenter.curatedOnboarding.whyTitle') }}</h5>
<ul>
    <li>
        <p class="h5 font-weight-bold mb-2">{{ __('helpcenter.curatedOnboarding.why1Title') }}</p>
        <p style="font-size: 16px;line-height: 1.7;">{{ __('helpcenter.curatedOnboarding.why1Body') }}</p>
    </li>
    <hr class="my-5">
    <li>
        <p class="h5 font-weight-bold mb-2">{{ __('helpcenter.curatedOnboarding.why2Title') }}</p>
        <p style="font-size: 16px;line-height: 1.7;">{{ __('helpcenter.curatedOnboarding.why2Body') }}</p>
    </li>
    <hr class="my-5">
    <li>
        <p class="h5 font-weight-bold mb-2">{{ __('helpcenter.curatedOnboarding.why3Title') }}</p>
        <p style="font-size: 16px;line-height: 1.7;">{{ __('helpcenter.curatedOnboarding.why3Body') }}</p>
    </li>
</ul>
<hr class="my-5">
<h5 class="text-center text-muted font-weight-light my-5">{{ __('helpcenter.curatedOnboarding.faqTitle') }}</h5>
<p>
    <a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse1" role="button" aria-expanded="false" aria-controls="collapse1">
        <i class="fas fa-chevron-down mr-2"></i>
        {{ __('helpcenter.curatedOnboarding.faq1Q') }}
    </a>
    <div class="collapse mb-5" id="collapse1">
        <div>
            {!! __('helpcenter.curatedOnboarding.faq1A') !!}
        </div>
    </div>
</p>
<p>
    <a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse2" role="button" aria-expanded="false" aria-controls="collapse2">
        <i class="fas fa-chevron-down mr-2"></i>
        {{ __('helpcenter.curatedOnboarding.faq2Q') }}
    </a>
    <div class="collapse mb-5" id="collapse2">
        <div>
            {{ __('helpcenter.curatedOnboarding.usernameTakenA') }}
        </div>
    </div>
</p>
<p>
    <a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse3" role="button" aria-expanded="false" aria-controls="collapse3">
        <i class="fas fa-chevron-down mr-2"></i>
        {{ __('helpcenter.curatedOnboarding.faq3Q') }}
    </a>
    <div class="collapse mb-5" id="collapse3">
        <div>
            {{ __('helpcenter.curatedOnboarding.faq3A') }}
        </div>
    </div>
</p>
<p>
    <a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse4" role="button" aria-expanded="false" aria-controls="collapse4">
        <i class="fas fa-chevron-down mr-2"></i>
        {{ __('helpcenter.curatedOnboarding.faq4Q') }}
    </a>
    <div class="collapse mb-5" id="collapse4">
        <div>
            {{ __('helpcenter.curatedOnboarding.usernameTakenA') }}
        </div>
    </div>
</p>
<p>
    <a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse5" role="button" aria-expanded="false" aria-controls="collapse5">
        <i class="fas fa-chevron-down mr-2"></i>
        {{ __('helpcenter.curatedOnboarding.faq5Q') }}
    </a>
    <div class="collapse mb-5" id="collapse5">
        <div>
            {{ __('helpcenter.curatedOnboarding.faq5A') }}
        </div>
    </div>
</p>
<p>
    <a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse6" role="button" aria-expanded="false" aria-controls="collapse6">
        <i class="fas fa-chevron-down mr-2"></i>
        {{ __('helpcenter.curatedOnboarding.faq6Q') }}
    </a>
    <div class="collapse mb-5" id="collapse6">
        <div>
            {{ __('helpcenter.curatedOnboarding.faq6A') }}
        </div>
    </div>
</p>
<p>
    <a class="text-dark font-weight-bold" data-toggle="collapse" href="#collapse7" role="button" aria-expanded="false" aria-controls="collapse7">
        <i class="fas fa-chevron-down mr-2"></i>
        {{ __('helpcenter.curatedOnboarding.faq7Q') }}
    </a>
    <div class="collapse mb-5" id="collapse7">
        <div>
            <p>{{ __('helpcenter.curatedOnboarding.faq7Intro') }}</p>

            <ul>
                <li>
                    {!! __('helpcenter.curatedOnboarding.faq7Item1') !!}
                </li>
                <li>
                    {!! __('helpcenter.curatedOnboarding.faq7Item2') !!}
                </li>
                <li>
                    {!! __('helpcenter.curatedOnboarding.faq7Item3') !!}
                </li>
                <li>
                    {!! __('helpcenter.curatedOnboarding.faq7Item4') !!}
                </li>
            </ul>

            <p>{{ __('helpcenter.curatedOnboarding.faq7Outro') }}</p>
            </p>
        </div>
    </div>
</p>
@endsection
