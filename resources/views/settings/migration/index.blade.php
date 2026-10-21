@extends('layouts.app')

@section('content')
@if (session('status'))
    <div class="alert alert-primary px-3 h6 font-weight-bold text-center">
        {{ session('status') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger px-3 h6 text-center">
            @foreach($errors->all() as $error)
                <p class="font-weight-bold mb-1">{{ $error }}</p>
            @endforeach
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger px-3 h6 text-center">
        {{ session('error') }}
    </div>
@endif

<div class="container">
  <div class="col-12">
    <div class="card shadow-none border mt-5">
      <div class="card-body">
        <div class="row">
          <div class="col-12 p-3 p-md-5">
            <div class="title">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="font-weight-bold">{{ __('settings.migration.account_migration') }}</h3>

                    <a class="font-weight-bold" href="/settings/home">
                        <i class="far fa-long-arrow-left"></i>
                        {{ __('settings.migration.back_to_settings') }}
                    </a>
                </div>
                <hr />
            </div>
            <div>
                @if($hasExistingMigration)
                <div class="row">
                    <div class="col-12 mt-5">
                        <p class="lead text-center">{{ __('settings.migration.you_have_migrated_your_account_already') }}</p>
                        <p>{{ __('settings.migration.you_can_only_migrate_your_account_once_per_30_days_etc') }}</p>
                    </div>
                </div>
                @else
                <div class="row">
                    <div class="col-12">
                        <p class="lead">{{ __('settings.migration.if_you_want_to_move_this_account_etc') }}</p>
                        <ul class="text-danger lead">
                            <li class="font-weight-bold">{{ __('settings.migration.only_followers_will_be_transferred_etc') }}</li>
                            <li>{{ __('settings.migration.this_process_will_transfer_all_followers_etc') }}</li>
                            <li>{{ __('settings.migration.a_redirect_notice_will_be_added_etc') }}</li>
                            <li>{{ __('settings.migration.you_must_set_up_the_new_account_to_link_back_etc') }}</li>
                            <li>{{ __('settings.migration.once_the_transfer_is_initiated_etc') }}</li>
                            <li>{{ __('settings.migration.after_the_transfer_your_current_account_will_be_limited_etc') }}</li>
                        </ul>
                        <p class="mb-0">{!! __('settings.migration.for_more_information_visit_the_help_center', ['url' => '/site/kb/your-profile']) !!}</p>
                        <hr>

                        <form method="post" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold mb-0">{{ __('settings.migration.new_account_handle') }}</label>
                                        <p class="small text-muted">{{ __('settings.migration.enter_the_username_domain_of_the_account_etc') }}</p>
                                        <input
                                            type="email"
                                            class="form-control"
                                            name="acct"
                                            placeholder="username@domain.tld"
                                            role="presentation"
                                            autocomplete="new-user-email"
                                        />
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold mb-0">{{ __('settings.migration.account_password') }}</label>
                                        <p class="small text-muted">{{ __('settings.migration.for_security_purposes_please_enter_the_password_etc') }}</p>
                                        <input
                                            type="password"
                                            class="form-control"
                                            name="password"
                                            role="presentation"
                                            placeholder="{{ __('settings.migration.your_account_password') }}"
                                            autocomplete="new-password"
                                            />
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-primary btn-block font-weight-bold btn-lg rounded-pill">{{ __('settings.migration.move_followers') }}</button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
