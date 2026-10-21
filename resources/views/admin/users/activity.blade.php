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
	<div class="col-12 col-md-8 offset-md-2">
		<p class="title h4 font-weight-bold mt-2 py-2">{{ __('admin_panel.users.activity.title') }}</p>
		<hr>
		<div class="row">
			<div class="col-12">
				@if($logs->count() > 0)
				<div class="list-group">
					@foreach($logs as $log)
					<div class="list-group-item d-flex justify-content-between align-items-center">
						<div>
							<p class="small text-muted font-weight-bold mb-0">{{$log->created_at->diffForHumans()}}</p>
							<p class="lead mb-0">{{$log->message}}</p>
							<p class="small text-muted font-weight-bold mb-0">
								IP: {{$log->ip_address}}
							</p>
						</div>
						<div>
							<i class="fas fa-chevron-right fa-lg text-lighter"></i>
						</div>
					</div>
					@endforeach
				</div>
				<div class="d-flex justify-content-center mt-3">
					{{$logs->links()}}
				</div>
				@else
				<div class="card card-body border shadow-none text-center">
					{{ __('admin_panel.users.activity.empty') }}
				</div>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection