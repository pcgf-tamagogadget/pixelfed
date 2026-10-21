@if($state)
<div class="card shadow-none border">
    @if($state === 'sent_invite')
    <div class="card-body d-flex justify-content-center flex-column align-items-center py-5" style="gap:1rem">
        <i class="far fa-envelope fa-3x"></i>
        <p class="lead mb-0 font-weight-bold">{{ __('settings.parental_controls.child_invite_sent') }}</p>

        <div class="list-group">
            <div class="list-group-item py-1"><i class="far fa-check-circle text-success mr-2"></i> {{ __('settings.parental_controls.created_child_invite') }}</div>
            <div class="list-group-item py-1"><i class="far fa-check-circle text-success mr-2"></i> {{ __('settings.parental_controls.sent_invite_email_to_child') }}</div>
            <div class="list-group-item py-1"><i class="far fa-times-circle text-dark mr-2"></i> {{ __('settings.parental_controls.child_joined_via_invite') }}</div>
            <div class="list-group-item py-1"><i class="far fa-times-circle text-dark mr-2"></i> {{ __('settings.parental_controls.child_account_is_active') }}</div>
        </div>
    </div>
    @elseif($state === 'awaiting_email_confirmation')
    <div class="card-body d-flex justify-content-center flex-column align-items-center py-5" style="gap:1rem">
        <i class="far fa-envelope fa-3x"></i>
        <p class="lead mb-0 font-weight-bold">{{ __('settings.parental_controls.child_invite_sent') }}</p>

        <div class="list-group">
            <div class="list-group-item py-1"><i class="far fa-check-circle text-success mr-2"></i> {{ __('settings.parental_controls.created_child_invite') }}</div>
            <div class="list-group-item py-1"><i class="far fa-check-circle text-success mr-2"></i> {{ __('settings.parental_controls.sent_invite_email_to_child') }}</div>
            <div class="list-group-item py-1"><i class="far fa-check-circle text-success mr-2"></i> {{ __('settings.parental_controls.child_joined_via_invite') }}</div>
            <div class="list-group-item py-1"><i class="far fa-times-circle text-dark mr-2"></i> {{ __('settings.parental_controls.child_account_is_active') }}</div>
        </div>
    </div>
    @elseif($state === 'active')
    <div class="card-body d-flex justify-content-center flex-column align-items-center py-5" style="gap:1rem">
        <i class="far fa-check-circle fa-3x text-success"></i>
        <p class="lead mb-0 font-weight-bold">{{ __('settings.parental_controls.child_account_active') }}</p>

        <div class="list-group">
            <div class="list-group-item py-1"><i class="far fa-check-circle text-success mr-2"></i> {{ __('settings.parental_controls.created_child_invite') }}</div>
            <div class="list-group-item py-1"><i class="far fa-check-circle text-success mr-2"></i> {{ __('settings.parental_controls.sent_invite_email_to_child') }}</div>
            <div class="list-group-item py-1"><i class="far fa-check-circle text-success mr-2"></i> {{ __('settings.parental_controls.child_joined_via_invite') }}</div>
            <div class="list-group-item py-1"><i class="far fa-check-circle text-success mr-2"></i> {{ __('settings.parental_controls.child_account_is_active') }}</div>
        </div>

        <a class="btn btn-dark font-weight-bold px-5" href="{{ $pc->childAccount()['url'] }}">{{ __('settings.parental_controls.view_account') }}</a>
    </div>
    @endif
</div>
@else
@endif
