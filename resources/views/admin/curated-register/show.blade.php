@extends('admin.partial.template-full')

@section('section')
</div><div class="header bg-primary pb-3 mt-n4">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-8 col-12">
                    <p class="mb-0">
                        <a href="{{ route('admin.curated-onboarding')}}" class="text-white">
                            <i class="far fa-chevron-left mr-1"></i> {{ __('admin_panel.curatedRegister.show.backToCuratedOnboarding') }}
                        </a>
                    </p>
                    <p class="display-3 text-white d-inline-block">{{ __('admin_panel.curatedRegister.show.application', ['id' => $record->id]) }}</p>
                    <div class="text-white mb-0 d-flex align-items-center" style="gap:1rem">
                        @if($record->is_closed)
                        @else
                            <span class="font-weight-bold">
                                <i class="far fa-circle mr-2"></i>
                                {{ __('admin_panel.curatedRegister.show.openAwaitingAction') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="m-n2 m-lg-4">
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card border">
                    <div class="card-header font-weight-bold bg-gradient-primary text-center text-white py-2">{{ __('admin_panel.curatedRegister.show.details') }}</div>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item">
                            <div>{{ __('admin_panel.common.username') }}</div>
                            <div>{{ $record->username }}</div>
                        </div>
                        <div class="list-group-item">
                            <div>{{ __('admin_panel.curatedRegister.show.email') }}</div>
                            <div>{{ $record->email }}</div>
                        </div>
                        <div class="list-group-item">
                            <div>{{ __('admin_panel.common.created') }}</div>
                            <div data-toggle="tooltip" title="{{ $record->created_at }}">{{ $record->created_at->diffForHumans() }}</div>
                        </div>
                        @if($record->email_verified_at)
                        <div class="list-group-item">
                            <div>{{ __('admin_panel.curatedRegister.show.emailVerified') }}</div>
                            <div data-toggle="tooltip" title="{{ $record->email_verified_at }}">{{ $record->email_verified_at->diffForHumans() }}</div>
                        </div>
                        @else
                        <div class="list-group-item">
                            <div>{{ __('admin_panel.curatedRegister.show.emailVerified') }}</div>
                            <div class="text-danger">{{ __('admin_panel.curatedRegister.show.notYet') }}</div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="card border mt-3">
                    <div class="card-header font-weight-bold bg-gradient-primary text-center text-white py-2">{{ __('admin_panel.curatedRegister.show.reasonForJoining') }}</div>
                    <div class="card-body">
                        <blockquote>{{ $record->reason_to_join }}</blockquote>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-8">
                @include('admin.curated-register.partials.activity-log', [
                    'id' => $record->id,
                    'is_closed' => $record->is_closed,
                    'is_approved' => $record->is_approved,
                    'is_rejected' => $record->is_rejected,
                    'action_taken_at' => $record->action_taken_at,
                    'email_verified_at' => $record->email_verified_at
                ])
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style type="text/css">
    .list-group-item {
        display: flex;
        justify-content: space-between;
        align-items: center;

        div:first-child {
                font-size: 12px;
        }

        div:last-child {
            font-weight: bold;
        }
    }
</style>
@endpush
