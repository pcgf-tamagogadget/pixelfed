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
				<a class="dropdown-item" href="/i/admin/users/modtools/{{$user->id}}">
					<span class="font-weight-bold">{{ __('admin_panel.users.header.modTools') }}</span>
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
		<p class="title h4 font-weight-bold mt-2 py-2">{{ __('admin_panel.users.modlogs.title') }}</p>
		<hr>
		<div class="row">
			<div class="col-12">
				<div class="card card-body shadow-none border mb-3">
					<form method="post">
						@csrf
						<div class="form-group">
							<textarea class="form-control" name="message" id="message" rows="4" style="resize: none;" placeholder="{{ __('admin_panel.users.modlogs.placeholder') }}"></textarea>
							@if ($errors->any())
							@foreach ($errors->all() as $error)
							<p class="invalid-feedback mb-0" style="display:block;">
								<strong>{{ $error }}</strong>
							</p>
							@endforeach
							@endif
						</div>
						<div>
							<span class="small text-muted font-weight-bold">
								<span class="msg-count">0</span>/500
							</span>
							<span class="float-right">
								<button class="btn btn-primary btn-sm py-1 font-weight-bold">{{ __('admin_panel.users.modlogs.send') }}</button>
							</span>
						</div>
					</form>
				</div>
				@if($logs->count() > 0)
				<div class="list-group">
					@foreach($logs as $log)
					<div class="list-group-item">
						@if($log->message != null)
						<div class="d-flex justify-content-between">
							<div class="mr-3">
								<img src="{{$log->admin->profile->avatarUrl()}}" width="40px" height="40px" class="border p-1 rounded-circle">
							</div>
							<div style="flex-grow: 1;">
								@if($log->user_id != Auth::id())
								<div class="p-3 bg-primary rounded">
									<p class="mb-0 text-white" style="font-weight: 600;">{{$log->message}}</p>
								</div>
								@else
								<div class="p-3 bg-white border rounded">
									<p class="mb-0 text-dark" style="font-weight: 600;">{{$log->message}}</p>
								</div>
								@endif
								<div class="d-flex justify-content-between small text-muted font-weight-bold mb-0 pt-2">
									<span class="mr-4">
										&commat;{{$log->user_username}}
									</span>
									<span>
										{{$log->created_at->diffForHumans()}}
									</span>
								</div>
							</div>
							@if($log->user_id == Auth::id())
							<div class="align-self-top ml-2">
								<form method="post" action="/i/admin/users/modlogs/{{$user->id}}/delete">
									@csrf
									<input type="hidden" name="mid" value="{{$log->id}}">
									<button type="submit" class="btn btn-text">
										<i class="fas fa-times text-lighter"></i>
									</button>
								</form>
							</div>
							@endif
						</div>
						@else
						<div class="d-flex justify-content-between align-items-center">
							<div class="mr-3">
								<img src="{{$log->admin->profile->avatarUrl()}}" width="40px" height="40px" class="border p-1 rounded-circle">
							</div>
							<div style="flex-grow: 1;">
								<p class="small text-muted font-weight-bold mb-0">{{$log->created_at->diffForHumans()}}</p>
								<p class="lead mb-0">{{$log->actionToText()}}</p>
								<p class="small text-muted font-weight-bold mb-0">
									{{ __('admin_panel.users.modlogs.by', ['username' => $log->user_username]) }}
								</p>
							</div>
							<div>
								<i class="fas fa-chevron-right fa-lg text-lighter"></i>
							</div>
						</div>
						@endif
					</div>
					@endforeach
				</div>
				<div class="d-flex justify-content-center mt-3">
					{{$logs->links()}}
				</div>
				@else
				<div class="card card-body border shadow-none text-center">
					{{ __('admin_panel.users.modlogs.empty') }}
				</div>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
	$('#message').on('keyup change paste submit', function(e) {
		let len = e.target.value.length;
		$('.msg-count').text(len);
	});
</script>
@endpush