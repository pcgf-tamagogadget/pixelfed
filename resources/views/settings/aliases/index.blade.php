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
                    <h3 class="font-weight-bold">{{ __('settings.aliases.manage_aliases') }}</h3>

                    <a class="font-weight-bold" href="/settings/home">
                        <i class="far fa-long-arrow-left"></i>
                        {{ __('settings.migration.back_to_settings') }}
                    </a>
                </div>

                <hr />

                <div class="row">
                    <div class="col-12 col-md-7">
                        <p class="lead">{{ __('settings.aliases.if_you_want_to_move_from_another_account_etc') }}</p>
                        <p>{{ __('settings.aliases.this_alias_is_needed_before_you_can_move_etc') }}</p>

                        <p class="mb-0">{!! __('settings.aliases.your_followers_will_be_migrated_etc', ['url' => '/site/kb/your-profile']) !!}</p>
                    </div>

                    <div class="col-12 col-md-5">
                        <div class="d-flex h-100 justify-content-center align-items-center flex-column">
                            <div class="border rounded-pill px-4 py-2">
                                <p class="small mb-n1 text-lighter font-weight-bold">{{ __('settings.aliases.old_account') }}</p>
                                <p class="lead mb-0">oldUsername@example.org</p>
                            </div>

                            <div class="border rounded-pill px-4 py-2 mt-3">
                                <p class="small mb-n1 text-lighter font-weight-bold">{{ __('settings.aliases.old_account') }}</p>
                                <p class="lead mb-0">oldUsername2@example.net</p>
                            </div>

                            <hr>
                            <p class="mb-0 small">{!! __('settings.aliases.we_support_migration_to_and_from_pixelfed_etc', ['url' => 'https://docs.joinmastodon.org/spec/activitypub/#Move']) !!}</p>
                        </div>

                    </div>
                </div>
            </div>
          </div>

          <div class="col-12">
            <hr>
          </div>
          <div class="col-12 col-md-7 p-3 p-md-5">
            <form method="post">
                @csrf

                <div class="form-group">
                    <label class="font-weight-bold mb-0">{{ __('settings.aliases.old_account') }}</label>
                    <p class="small text-muted">{{ __('settings.aliases.enter_the_username_domain_of_your_old_account') }}</p>
                    <input type="email" class="form-control" name="acct" placeholder="username@domain.tld"/>
                </div>

                <button class="btn btn-primary btn-block font-weight-bold btn-lg">{{ __('settings.aliases.create_alias') }}</button>
            </form>
          </div>

          <div class="col-12 col-md-5 p-3 p-md-5 bg-white">
            <p class="text-center font-weight-bold">{{ __('settings.aliases.aliases') }}</p>
            <div class="list-group">
                @if(count($aliases))
                @foreach($aliases as $alias)
                <div class="list-group-item d-flex justify-content-between">
                    <div class="mb-0 font-weight-bold small text-break">
                        {{ $alias->acct }}
                    </div>

                    <div class="ml-2 mb-0 font-weight-bold small">
                        <form action="/settings/account/aliases/manage/delete" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $alias->id }}">
                            <input type="hidden" name="acct" value="{{ $alias->acct }}">
                            <button class="btn btn-link btn-sm p-0">
                                <i class="far fa-trash-alt text-danger"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
                @else
                <div class="border rounded p-5">
                    <p class="text-center mb-0">{{ __('settings.aliases.no_aliases_found') }}</p>
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
