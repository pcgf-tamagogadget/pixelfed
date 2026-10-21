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
				<a class="dropdown-item" href="/i/admin/users/modlogs/{{$user->id}}">
					<span class="font-weight-bold">{{ __('admin_panel.users.header.modLogs') }}</span>
				</a>
			</div>
		</div>
	</span>
</div>
<hr>
<div class="row">
	<div class="col-12 col-md-8 offset-md-2">
		<div class="card card-body">
			<p class="lead text-center py-5">{{ __('admin_panel.users.delete.confirm') }}</p>
			<p class="mb-0">
				<form method="post" id="deleteForm">
					@csrf
					<button type="button" id="confirmDelete" class="btn btn-danger btn-block font-weight-bold">{{ __('admin_panel.users.delete.button') }}</button>
				</form>
			</p>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
	$('#confirmDelete').click(function(e) {
		e.preventDefault();

		if(window.confirm(@json(__('admin_panel.users.delete.confirm'))) == true) {
			if(window.confirm(@json(__('admin_panel.users.delete.confirmAgain'))) == true) {
				$('#deleteForm').submit();
			}
		}
	})
</script>
@endpush