@extends('admin.partial.template-full')

@section('section')
<div class="title d-flex justify-content-between align-items-center">
	<span><a href="{{route('admin.users')}}" class="btn btn-outline-secondary btn-sm font-weight-bold">{{ __('admin_panel.common.back') }}</a></span>
	<span class="text-center">
		<h3 class="font-weight-bold mb-0">&commat;{{$profile->username}}</h3>
		<p class="mb-0 small text-muted text-uppercase font-weight-bold">
			<span>{{ __('admin_panel.users.header.postsCount', ['count' => $profile->statuses()->count()]) }}</span>
			<span class="px-1">|</span>
			<span>{{ __('admin_panel.users.header.followersCount', ['count' => $profile->followers()->count()]) }}</span>
			<span class="px-1">|</span>
			<span>{{ __('admin_panel.users.header.followingCount', ['count' => $profile->following()->count()]) }}</span>
		</p>
	</span>
	<span>
		<div class="dropdown">
			<button class="btn btn-outline-secondary btn-sm font-weight-bold dropdown-toggle" type="button" id="userActions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars"></i></button>
			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userActions">
				<a class="dropdown-item" href="/i/admin/users/activity/{{$user->id}}">
					<span class="font-weight-bold">{{ __('admin_panel.users.header.activity') }}</span>
				</a>
				<a class="dropdown-item" href="/i/admin/users/message/{{$user->id}}">
					<span class="font-weight-bold">{{ __('admin_panel.users.header.sendMessage') }}</span>
				</a>
				<a class="dropdown-item" href="{{$profile->url()}}">
					<span class="font-weight-bold">{{ __('admin_panel.users.header.viewProfile') }}</span>
				</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="/i/admin/users/edit/{{$user->id}}">
					<span class="font-weight-bold">{{ __('admin_panel.common.edit') }}</span>
				</a>
				<a class="dropdown-item" href="/i/admin/users/modtools/{{$user->id}}">
					<span class="font-weight-bold">{{ __('admin_panel.users.header.modTools') }}</span>
				</a>
				<a class="dropdown-item" href="/i/admin/users/modlogs/{{$user->id}}">
					<span class="font-weight-bold">{{ __('admin_panel.users.header.modLogs') }}</span>
				</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="/i/admin/users/delete/{{$user->id}}">
					<span class="text-danger font-weight-bold">{{ __('admin_panel.users.header.deleteAccount') }}</span>
				</a>
			</div>
		</div>
	</span>
</div>
<hr>
<div class="row mb-3">
	<div class="col-12 col-md-4">
		<div class="card shadow-none border">
			<div class="card-body text-center">
				<img src="{{$profile->avatarUrl()}}" class="box-shadow rounded-circle" width="128px" height="128px">
				<p class="mt-3 mb-0 lead">
					<span class="font-weight-bold">{{$profile->name}}</span>
				</p>
				@if($user->is_admin == true)
				<p class="mb-0">
					<span class="badge badge-danger badge-sm">{{ __('admin_panel.users.show.admin') }}</span>
				</p>
				@endif

                <div class="d-flex justify-content-around mt-3">
                    <div class="mb-0">
                        <p class="mb-n2 text-center text-dark font-weight-bold">
                            {{$profile->created_at->diffForHumans()}}
                        </p>
        				<p class="mb-0 text-center text-muted">
        					<span class="small">{{ __('admin_panel.users.show.joined') }}</span>
        				</p>
                    </div>
                    @if($user->last_active_at)
                    <div class="mb-0">
                        <p class="mb-n2 text-center text-dark font-weight-bold">
                            {{$user->last_active_at->diffForHumans()}}
                        </p>
                        <p class="mb-0 text-center text-muted">
                            <span class="small">{{ __('admin_panel.users.show.lastActive') }}</span>
                        </p>
                    </div>
                    @endif
                </div>
			</div>

            <div class="list-group list-group-flush details-list">
                <div class="list-group-item details-list-item">
                    <p class="details-list-item-title">{{ __('admin_panel.users.show.email') }}</p>
                    <p class="details-list-item-value text-truncate" title="{{$user->email}}">{{$user->email}}</p>
                </div>

                @if($profile->website)
                <div class="list-group-item details-list-item">
                    <p class="details-list-item-title">{{ __('admin_panel.users.show.website') }}</p>
                    <p class="details-list-item-value text-truncate" title="{{$profile->website}}">{{$profile->website}}</p>
                </div>
                @endif

                <div class="list-group-item details-list-item">
                    <p class="details-list-item-title">{{ __('admin_panel.users.show.bookmarks') }}</p>
                    <p class="details-list-item-value text-truncate">{{$profile->bookmarks()->count()}}</p>
                </div>

                <div class="list-group-item details-list-item">
                    <p class="details-list-item-title">{{ __('admin_panel.users.show.collections') }}</p>
                    <p class="details-list-item-value text-truncate">{{$profile->collections()->count()}}</p>
                </div>

                <div class="list-group-item details-list-item">
                    <p class="details-list-item-title">{{ __('admin_panel.users.show.likes') }}</p>
                    <p class="details-list-item-value text-truncate">{{$profile->likes()->count()}}</p>
                </div>

                <div class="list-group-item details-list-item">
                    <p class="details-list-item-title">{{ __('admin_panel.users.show.reports') }}</p>
                    <p class="details-list-item-value text-truncate">{{$profile->reports()->count()}}</p>
                </div>

                <div class="list-group-item details-list-item">
                    <p class="details-list-item-title">{{ __('admin_panel.users.show.reported') }}</p>
                    <p class="details-list-item-value text-truncate">{{$profile->reported()->count()}}</p>
                </div>

                <div class="list-group-item details-list-item">
                    <p class="details-list-item-title">{{ __('admin_panel.users.show.activeStories') }}</p>
                    <p class="details-list-item-value text-truncate">{{$profile->stories()->count()}}</p>
                </div>

                <div class="list-group-item details-list-item">
                    <p class="details-list-item-title">{{ __('admin_panel.users.show.storageUsed') }}</p>
                    <p class="details-list-item-value text-truncate">{{PrettyNumber::size($profile->media()->sum('size'))}}<span class="text-muted"> / {{PrettyNumber::size(config_cache('pixelfed.max_account_size') * 1000)}}</p>
                </div>

                <div class="list-group-item details-list-item">
                    <p class="details-list-item-title">{{ __('admin_panel.users.show.bio') }}</p>
                    <p class="details-list-item-value text-wrap text-xs">{{ $profile->bio }}</p>
                </div>
            </div>
		</div>
	</div>
	<div class="col-12 col-md-8">
		<p class="title h4 font-weight-bold mt-2 py-2">{{ __('admin_panel.users.show.recentPosts') }}</p>
		<hr>
		<div class="row">
			@foreach($profile->statuses()->whereHas('media')->latest()->take(16)->get() as $item)
            @php($post = \App\Services\StatusService::get($item->id, false))
			<div class="col-12 col-md-3 col-sm-6 mb-3 px-0">
				<a href="{{$item->url()}}">
                    @if($post)
                    <img src="{{$post['media_attachments'][0]['url']}}" width="200px" height="200px" style="object-fit: cover;" onerror="this.src='/storage/no-preview.png';this.onerror=null;">
                    @else
					<img src="/storage/no-preview.png" width="200px" height="200px">
                    @endif
				</a>
			</div>
			@endforeach

			@if($profile->statuses()->whereHas('media')->count() == 0)
			<div class="col-12">
				<div class="card card-body border shadow-none bg-transparent">
					<p class="text-center mb-0 text-muted">{{ __('admin_panel.users.show.noStatuses') }}</p>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>
@endsection

@push('styles')
<style type="text/css">
    .gap-1 {
        gap: 5rem;
    }

    .details-list {

    }

    .details-list-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 5rem;
        border-left: 0;
        border-right: 0;
    }

    .details-list-item-title {
        margin-bottom: 0;
        color: #9ca3af !important;
        text-transform: uppercase !important;
        font-weight: bold;
        font-size: 13px;
        opacity: 0.69;
    }

    .details-list-item-value {
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 0;
    }

    .text-xs {
        font-size: 11px !important;
        font-weight: normal;
    }
</style>
@endpush
