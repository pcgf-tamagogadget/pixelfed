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

<div class="col-12 col-md-8 offset-md-2">
	<p class="title h4 font-weight-bold mt-2 py-2">{{ __('admin_panel.common.edit') }}</p>
	<hr>
	<div class="row">
		<div class="col-12">
			<form method="post">
				@csrf
				<div class="form-group">
					<label class="font-weight-bold text-muted">{{ __('admin_panel.users.edit.displayName') }}</label>
					<input type="text" class="form-control" name="name" value="{{$user->name}}">
				</div>
				<div class="form-group">
					<label class="font-weight-bold text-muted">{{ __('admin_panel.common.username') }}</label>
					<input type="text" class="form-control" name="username" value="{{$user->username}}">
				</div>
				<div class="form-group">
					<label class="font-weight-bold text-muted">{{ __('admin_panel.users.edit.email') }}</label>
					<input type="email" class="form-control" name="email" value="{{$user->email}}" placeholder="{{ __('admin_panel.users.edit.emailPlaceholder') }}">
					<p class="help-text small text-muted font-weight-bold">
						@if($user->email_verified_at)
						{!! __('admin_panel.users.edit.verifiedFor', ['time' => e($user->email_verified_at->diffForHumans())]) !!}
						@else
						{!! __('admin_panel.users.edit.unverified') !!}
						@endif
					</p>
				</div>
				<div class="form-group">
					<label class="font-weight-bold text-muted">{{ __('admin_panel.users.edit.bio') }}</label>
					<textarea class="form-control" rows="4" name="bio" placeholder="{{ __('admin_panel.users.edit.bioPlaceholder') }}">{{$profile->bio}}</textarea>
				</div>
				<div class="form-group">
					<label class="font-weight-bold text-muted">{{ __('admin_panel.users.edit.website') }}</label>
					<input type="text" class="form-control" name="website" value="{{$profile->website}}" placeholder="{{ __('admin_panel.users.edit.websitePlaceholder') }}">
				</div>
				<div class="form-group">
					<label class="font-weight-bold text-muted">{{ __('admin_panel.users.edit.admin') }}</label>
					<div class="custom-control custom-switch">
						<input type="checkbox" class="custom-control-input" id="customSwitch1" {{$user->is_admin ? 'checked="checked"' : ''}}>
						<label class="custom-control-label" for="customSwitch1"></label>
					</div>
					<p class="help-text small text-muted font-weight-bold">{{ __('admin_panel.users.edit.adminHelp') }}</p>
				</div>
				<hr>
				<p class="float-right">
					<button type="submit" class="btn btn-primary font-weight-bold py-1">{{ __('admin_panel.users.edit.save') }}</button>
				</p>
			</form>
		</div>
	</div>
</div>

@endsection
