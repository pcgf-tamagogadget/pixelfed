@extends('admin.partial.template-full')

@section('section')
    <div class="container-fluid">
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <div class="display-1 font-weight-bold text-dark mb-0">
                    {{ __('admin_panel.users.invites.home.title') }}
                </div>
                <p class="text-muted mb-0">{{ __('admin_panel.users.invites.home.subtitle') }}</p>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-md-end mb-4">
                    <a href="{{ route('admin.users.invites.create') }}" class="btn btn-primary" title="{{ __('admin_panel.users.invites.home.newInvite') }}">
                        <span class="font-weight-bold">{{ __('admin_panel.users.invites.home.newInvite') }}</span>
                    </a>
                </div>
            </div>
        </div>

        @if (session('status'))
            <div class="row justify-content-center">
                <div class="col-12" id="flash">
                    <div class="alert alert-success">
                        {!! session('status') !!}
                    </div>
                </div>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table">
                <thead class="bg-light">
                <tr>
                    <th scope="col" class="border-0">
                        <span>{{ __('admin_panel.users.invites.home.code') }}</span>
                    </th>
                    <th scope="col" class="border-0">
                        <span>{{ __('admin_panel.users.invites.home.name') }}</span>
                    </th>
                    <th scope="col" class="border-0">
                        <span>{{ __('admin_panel.users.invites.home.description') }}</span>
                    </th>
                    <th scope="col" class="border-0">
                        <span>{{ __('admin_panel.users.invites.home.remainingUses') }}</span>
                    </th>
                    <th scope="col" class="border-0">
                        <span>{{ __('admin_panel.users.invites.home.expires') }}</span>
                    </th>
                    <th scope="col" class="border-0">
                        <span>{{ __('admin_panel.common.actions') }}</span>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($invites as $invite)
                    <tr class="font-weight-bold">
                        <td class="text-truncate" data-toggle="tooltip" data-placement="bottom" title="{{ $invite->description }}" style="max-width: 100px;">
                            <a href="{{ $invite->url() }}">{{ $invite->invite_code }}</a>
                        </td>
                        <td>
                            {{$invite->name}}
                        </td>
                        <td class="text-truncate" data-toggle="tooltip" data-placement="bottom" title="{{ $invite->description }}" style="max-width: 200px;">
                            {{ $invite->description }}
                        </td>
                        <td>
                            {{ $invite->max_uses ? ($invite->max_uses - $invite->uses) : '∞' }}
                        </td>
                        <td data-toggle="tooltip" data-placement="bottom" title="{{ $invite->expires_at?->toDateTimeString() ?? '' }}" style="max-width: 80px;">
                            {{ $invite->hasExpired() ? __('admin_panel.users.invites.home.expired') : ($invite->expires_at?->diffForHumans() ?? __('admin_panel.users.invites.home.never')) }}
                        </td>
                        <td>
                            <button class="btn btn-outline-secondary btn-sm py-0 mr-3 expire-invite"
                                    data-name="{{ $invite->name ?? $invite->invite_code }}"
                                    data-route="{{ route('admin.users.invites.expire', $invite) }}"
                                    type="button">
                                {{ __('admin_panel.users.invites.home.expire') }}
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-5 small">
                {{ $invites->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.expire-invite').forEach(el => {
            el.addEventListener('click', (event) => {
                event.preventDefault()

                const inviteName = el.dataset.name
                const deletionRoute = el.dataset.route

                swal({
                    title: @json(__('admin_panel.users.invites.home.expireTitle')),
                    text: @json(__('admin_panel.users.invites.home.expireConfirm')).replace(':name', () => inviteName),
                    icon: 'warning',
                    dangerMode: true,
                    buttons: {
                        cancel: {
                            text: @json(__('admin_panel.common.cancel')),
                            value: false,
                            visible: true,
                        },
                        expire: {
                            text: @json(__('admin_panel.users.invites.home.expire')),
                            value: 'expire',
                            className: 'btn-danger'
                        }
                    }
                })
                    .then((willExpire) => {
                        if (willExpire === 'expire') {
                            swal({
                                title: @json(__('admin_panel.users.invites.home.deleting')),
                                text: @json(__('admin_panel.users.invites.home.expiringWait')),
                                icon: 'info',
                                buttons: false,
                                closeOnClickOutside: false,
                                closeOnEsc: false
                            })

                            axios.post(deletionRoute)
                                .then(res => {
                                    swal(@json(__('admin_panel.users.invites.home.success')), @json(__('admin_panel.users.invites.home.expireSuccess')), 'success')
                                        .then(() => {
                                            window.location.reload()
                                        })
                                })
                                .catch(err => {
                                    console.error('Expire error:', err)
                                    swal(@json(__('admin_panel.users.invites.home.error')), @json(__('admin_panel.users.invites.home.expireFailed')), 'error')
                                })
                        }
                    })
            })
        })
    </script>
@endpush
