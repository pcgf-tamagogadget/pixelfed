@extends('admin.partial.template-full')

@section('section')
<div class="title d-flex justify-content-between align-items-center">
	<span><a href="/i/admin/users/show/{{$user->id}}" class="btn btn-outline-secondary btn-sm font-weight-bold">{{ __('admin_panel.common.back') }}</a></span>
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
				<a class="dropdown-item" href="/i/admin/users/show/{{$user->id}}">
					<span class="font-weight-bold">{{ __('admin_panel.users.header.overview') }}</span>
				</a>
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
	<div class="col-12 col-md-8 offset-md-2">
		<p class="title h4 font-weight-bold mt-2 py-2">{{ __('admin_panel.users.header.modTools') }}</p>
		<hr>
		<div class="row">
			<div class="col-12 col-md-6">
				<form method="post" action="/i/admin/users/moderation/update" class="pb-3">
					@csrf
					<input type="hidden" name="action" value="cw">
					<input type="hidden" name="profile_id" value="{{$profile->id}}">
					<button class="btn btn-outline-{{$profile->cw ? 'secondary' : 'primary'}} py-0 font-weight-bold">
						{{ $profile->cw ? __('admin_panel.users.modtools.removeCw') : __('admin_panel.users.modtools.enforceCw') }}
					</button>
					<p class="help-text text-muted font-weight-bold small">{{ __('admin_panel.users.modtools.cwHelp') }}</p>
				</form>
			</div>
			<div class="col-12 col-md-6">
				<form method="post" action="/i/admin/users/moderation/update" class="pb-3">
					@csrf
					<input type="hidden" name="action" value="unlisted">
					<input type="hidden" name="profile_id" value="{{$profile->id}}">
					<button class="btn btn-outline-{{$profile->unlisted ? 'secondary' : 'primary'}} py-0 font-weight-bold">
						{{ $profile->unlisted ? __('admin_panel.users.modtools.removeUnlisting') : __('admin_panel.users.modtools.unlistedPosts') }}
					</button>
					<p class="help-text text-muted font-weight-bold small">{{ __('admin_panel.users.modtools.unlistedHelp') }}</p>
				</form>
			</div>
			<div class="col-12 col-md-6">
				<form method="post" action="/i/admin/users/moderation/update" class="pb-3">
					@csrf
					<input type="hidden" name="action" value="no_autolink">
					<input type="hidden" name="profile_id" value="{{$profile->id}}">
					<button class="btn btn-outline-{{$profile->no_autolink ? 'secondary' : 'primary'}} py-0 font-weight-bold">
						{{ $profile->no_autolink ? __('admin_panel.users.modtools.removeNoAutolink') : __('admin_panel.users.modtools.noAutolink') }}
					</button>
					<p class="help-text text-muted font-weight-bold small">{{ __('admin_panel.users.modtools.noAutolinkHelp') }}</p>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection