@extends('layouts.blank')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center">
        <div class="col-12 col-md-7">
            <div class="logo">
                <img src="{{ config('app.logo') }}" width="40" height="40" alt="{{ __('auth.curated.logoAlt') }}">
                <p class="font-weight-bold mb-0">Pixelfed</p>
            </div>

            @include('auth.curated-register.partials.progress-bar', ['step' => 3])

            <div class="alert alert-muted bg-transparent border-muted p-4 text-center mt-5">
                <p class="text-center text-success mb-4"><i class="far fa-envelope-open fa-4x"></i></p>
                <p class="h2 font-weight-bold text-white">{{ __('auth.curated.checkInbox') }}</p>
                <hr style="opacity: 0.2">
                <p class="lead text-white">{{ __('auth.curated.sentConfirmLink') }}</p>
                <p class="text-muted mb-0">{{ __('auth.curated.linkExpires') }}</p>
            </div>
        </div>
        <div class="col-12 col-md-7 mt-5">
            <div class="small-links">
                <a href="/">{{ __('auth.curated.home') }}</a>
                <span>·</span>
                <a href="/login">{{ __('auth.login') }}</a>
                <span>·</span>
                <a href="{{route('help.curated-onboarding')}}" target="_blank">{{ __('auth.curated.help') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link href="{{ mix('css/landing.css') }}" rel="stylesheet">
    <style type="text/css">
        .gap-1 {
            gap: 1rem;
        }

        .opacity-5 {
            opacity: .5;
        }

        .logo {
            display: flex;
            margin-top: 50px;
            align-items: center;
            justify-content: center;
            gap: 1rem;

            p {
                font-size: 30px;
            }
        }

        .action-btns {
            display: flex;
            margin: 3rem auto 1rem auto;
            flex-direction: row;
            gap: 1rem;

            form {
                flex-grow: 1;
            }
        }

        .small-links {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: row;
            margin-bottom: 5rem;
            gap: 1rem;

            a {
                color: rgba(255, 255, 255, 0.6);
                font-size: 12px;
            }

            span {
                color: rgba(255, 255, 255, 0.4);
            }
        }
    </style>
@endpush
