@extends('site.help.partial.template', ['breadcrumb'=>__('helpcenter.accountMigration.title')])

@section('section')

    <div class="title">
        <h3 class="font-weight-bold">{{ __('helpcenter.accountMigration.title') }}</h3>
    </div>

    <hr>

    @if((bool) config_cache('federation.migration') === false)
    <div class="alert alert-danger">
        <p class="font-weight-bold mb-0">{{ __('helpcenter.accountMigration.notAvailable') }}</p>
    </div>
    @endif

    <p class="lead">{{ __('helpcenter.accountMigration.p1') }}</p>
    <p class="lead">{{ __('helpcenter.accountMigration.p2') }}</p>
@endsection
