@extends('settings.template-vue')

@section('section')
<form class="d-flex h-100 flex-column" method="post">
    @csrf
<div class="d-flex h-100 flex-column">
    <div class="d-flex justify-content-between align-items-center">
        <div class="title d-flex align-items-center" style="gap: 1rem;">
            <p class="mb-0"><a href="/settings/parental-controls"><i class="far fa-chevron-left fa-lg"></i></a></p>
            <div>
                <h3 class="font-weight-bold mb-0">{{ __('settings.parental_controls.manage_child') }}</h3>
                <p class="small mb-0">{{ __('settings.parental_controls.last_updated', ['time' => $pc->updated_at->diffForHumans()]) }}</p>
            </div>
        </div>

        <button class="btn btn-dark font-weight-bold">{{ __('settings.parental_controls.update') }}</button>
    </div>

    <hr />

    <div class="d-flex flex-column flex-grow-1">
        <ul class="nav nav-pills mb-0" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active font-weight-bold" id="pills-status-tab" data-toggle="pill" data-target="#pills-status" type="button" role="tab" aria-controls="pills-status" aria-selected="true">{{ __('settings.parental_controls.status') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link font-weight-bold" id="pills-permissions-tab" data-toggle="pill" data-target="#pills-permissions" type="button" role="tab" aria-controls="pills-permissions" aria-selected="false">{{ __('settings.parental_controls.permissions') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link font-weight-bold" id="pills-details-tab" data-toggle="pill" data-target="#pills-details" type="button" role="tab" aria-controls="pills-details" aria-selected="false">{{ __('settings.parental_controls.account_details') }}</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link font-weight-bold" id="pills-actions-tab" data-toggle="pill" data-target="#pills-actions" type="button" role="tab" aria-controls="pills-actions" aria-selected="false">{{ __('settings.parental_controls.actions') }}</button>
            </li>
        </ul>
        <div>
            <hr>
        </div>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-status" role="tabpanel" aria-labelledby="pills-status-tab">
                @if(!$pc->child_id && !$pc->email_verified_at)
                @include('settings.parental-controls.child-status', ['state' => 'sent_invite'])
                @elseif($pc->child_id && !$pc->email_verified_at)
                @include('settings.parental-controls.child-status', ['state' => 'awaiting_email_confirmation'])
                @elseif($pc->child_id && $pc->email_verified_at)
                @include('settings.parental-controls.child-status', ['state' => 'active'])
                @else
                @include('settings.parental-controls.child-status', ['state' => 'sent_invite'])
                @endif
            </div>
            <div class="tab-pane fade" id="pills-permissions" role="tabpanel" aria-labelledby="pills-permissions-tab">
                <div class="mb-4">
                    <p class="font-weight-bold mb-1">{{ __('settings.parental_controls.allowed_actions') }}</p>

                    @include('settings.parental-controls.checkbox', ['name' => 'post', 'title' => __('settings.parental_controls.post'), 'checked' => $pc->permissions['post']])
                    @include('settings.parental-controls.checkbox', ['name' => 'comment', 'title' => __('settings.parental_controls.comment'), 'checked' => $pc->permissions['comment']])
                    @include('settings.parental-controls.checkbox', ['name' => 'like', 'title' => __('settings.parental_controls.like'), 'checked' => $pc->permissions['like']])
                    @include('settings.parental-controls.checkbox', ['name' => 'share', 'title' => __('settings.parental_controls.share'), 'checked' => $pc->permissions['share']])
                    @include('settings.parental-controls.checkbox', ['name' => 'follow', 'title' => __('settings.parental_controls.follow'), 'checked' => $pc->permissions['follow']])
                    @include('settings.parental-controls.checkbox', ['name' => 'bookmark', 'title' => __('settings.parental_controls.bookmark'), 'checked' => $pc->permissions['bookmark']])
                    @include('settings.parental-controls.checkbox', ['name' => 'story', 'title' => __('settings.parental_controls.add_to_story'), 'checked' => $pc->permissions['story']])
                    @include('settings.parental-controls.checkbox', ['name' => 'collection', 'title' => __('settings.parental_controls.add_to_collection'), 'checked' => $pc->permissions['collection']])
                </div>
                <div class="mb-4">
                    <p class="font-weight-bold mb-1">{{ __('settings.parental_controls.enabled_features') }}</p>

                    @include('settings.parental-controls.checkbox', ['name' => 'discovery_feeds', 'title' => __('settings.parental_controls.discovery_feeds'), 'checked' => $pc->permissions['discovery_feeds']])
                    @include('settings.parental-controls.checkbox', ['name' => 'dms', 'title' => __('settings.parental_controls.direct_messages'), 'checked' => $pc->permissions['dms']])
                    @include('settings.parental-controls.checkbox', ['name' => 'federation', 'title' => __('settings.parental_controls.federation'), 'checked' => $pc->permissions['federation']])
                </div>
                <div class="mb-4">
                    <p class="font-weight-bold mb-1">{{ __('settings.parental_controls.preferences') }}</p>

                    @include('settings.parental-controls.checkbox', ['name' => 'hide_network', 'title' => __('settings.parental_controls.hide_my_childs_connections'), 'checked' => $pc->permissions['hide_network']])
                    @include('settings.parental-controls.checkbox', ['name' => 'private', 'title' => __('settings.parental_controls.make_my_childs_account_private'), 'checked' => $pc->permissions['private']])
                    @include('settings.parental-controls.checkbox', ['name' => 'hide_cw', 'title' => __('settings.parental_controls.hide_sensitive_media'), 'checked' => $pc->permissions['hide_cw']])
                </div>
            </div>
            <div class="tab-pane fade" id="pills-details" role="tabpanel" aria-labelledby="pills-details-tab">
                <div>
                    <div class="form-group">
                        <label class="font-weight-bold mb-0">{{ __('settings.parental_controls.email_address') }}</label>
                        <input class="form-control" name="email" value="{{ $pc->email }}" disabled>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-actions" role="tabpanel" aria-labelledby="pills-actions-tab">
                <div class="d-flex flex-column" style="gap: 2rem;">
                    @if(!$pc->child_id && !$pc->email_verified_at)
                    <div>
                        <p class="lead font-weight-bold mb-0">{{ __('settings.parental_controls.cancel_invite_title') }}</p>
                        <p class="small text-muted">{{ __('settings.parental_controls.cancel_the_child_invite_and_prevent_it_etc') }}</p>
                        <a class="btn btn-outline-dark px-5" href="{{ route('settings.pc.cancel-invite', ['id' => $pc->id]) }}"><i class="fas fa-user-minus mr-1"></i> {{ __('settings.parental_controls.cancel_invite_title') }}</a>
                    </div>
                    @else
                    <div>
                        <p class="lead font-weight-bold mb-0">{{ __('settings.parental_controls.stop_managing') }}</p>
                        <p class="small text-muted">{{ __('settings.parental_controls.transition_account_to_a_regular_account_etc') }}</p>
                        <a class="btn btn-outline-dark px-5" href="{{ route('settings.pc.stop-managing', ['id' => $pc->id]) }}"><i class="fas fa-user-minus mr-1"></i> {{ __('settings.parental_controls.stop_managing_child') }}</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
</form>
@endsection

@push('scripts')
<script type="text/javascript">
    @if(request()->has('permissions'))
    $('#pills-tab button[data-target="#pills-permissions"]').tab('show')
    @elseif(request()->has('actions'))
    $('#pills-tab button[data-target="#pills-actions"]').tab('show')
    @endif
</script>
@endpush
