@extends('layouts.blank')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center">
        <div class="col-12 col-md-7">
            <div class="logo">
                <img src="{{ config('app.logo') }}" width="40" height="40" alt="{{ __('auth.curated.logoAlt') }}">
                <p class="font-weight-bold mb-0">Pixelfed</p>
            </div>

            @include('auth.curated-register.partials.progress-bar', ['step' => 4])

            <p class="text-center"><i class="fal fa-check-circle text-success fa-8x"></i></p>
            <h1 class="text-center font-weight-bold my-4">{{ __('auth.curated.responseSent') }}</h1>
            <p class="h4 text-center"><span class="font-weight-bold">{{ __('auth.curated.adminWillReview') }}</span></p>
            <hr class="border-dark">
            <p class="lead text-center">{{ __('auth.curated.processingTime') }}</p>
            <p class="text-muted text-center">{{ __('auth.curated.additionalInfoHint') }}</p>
            <hr class="border-dark">
            <p class="text-muted small text-center">{!! __('auth.curated.helpCenterHint', ['link' => '<a href="'.e(route('help.curated-onboarding')).'" style="font-weight: 600;">'.e(__('auth.curated.curatedOnboarding')).'</a>']) !!}</p>
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
