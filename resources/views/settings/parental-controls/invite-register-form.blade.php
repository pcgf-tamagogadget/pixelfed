@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-none border mb-3">
                <a
                    class="card-body d-flex flex-column justify-content-center align-items-center text-decoration-none"
                    href="{{ $pc->parent->url() }}"
                    target="_blank">
                    <p class="text-center font-weight-bold text-muted">{{ __('settings.parental_controls.youve_been_invited_by') }}</p>

                    <div class="media align-items-center">
                        <img
                            src="{{ $pc->parent->avatarUrl() }}"
                            width="30"
                            height="30"
                            class="rounded-circle mr-2"
                            draggable="false"
                            onerror="this.onerror=null;this.src='/storage/avatars/default.png?v=0';">

                        <div class="media-body">
                            <p class="lead font-weight-bold mb-0 text-dark" style="line-height: 1;">&commat;{{ $pc->parent->username }}</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="card shadow-none border">
                <div class="card-header bg-white p-3 text-center font-weight-bold">{{ __('settings.parental_controls.create_your_account') }}</div>

                <div class="card-body">
                    <form method="POST" class="px-md-3">
                        @csrf
                        @honeypot
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="small font-weight-bold text-lighter">{{ __('auth.name') }}</label>
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="{{ __('auth.name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="small font-weight-bold text-lighter">{{ __('auth.username') }}</label>
                                <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" placeholder="{{ __('auth.username') }}" required>

                                @if ($errors->has('username'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="small font-weight-bold text-lighter">{{ __('auth.password') }}</label>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('auth.password') }}" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="small font-weight-bold text-lighter">{{ __('auth.confirm-password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{ __('auth.confirm-password') }}" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-check">
                                  <input class="form-check-input" name="agecheck" type="checkbox" value="true" id="ageCheck" required>
                                  <label class="form-check-label" for="ageCheck">
                                    {{ __('settings.parental_controls.i_am_at_least_years_old', ['age' => (int) config('pixelfed.min_registration_age', 16)]) }}
                                  </label>
                                </div>
                            </div>
                        </div>

                        <x-captcha surface="register" />

                        <p class="small">{!! __('settings.parental_controls.by_signing_up_you_agree_etc', ['terms' => e(route('site.terms')), 'privacy' => e(route('site.privacy')), 'username' => e($pc->parent->username), 'help' => '/site/kb/parental-controls']) !!}</p>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block py-0 font-weight-bold">
                                    {{ __('auth.register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
