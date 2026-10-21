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
		<p class="title h4 font-weight-bold mt-2 py-2">{{ __('admin_panel.users.header.sendMessage') }}</p>
		<hr>
		<div class="row">
			<div class="col-12">
				@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
				@endif
				<form method="post" id="messageForm">
					@csrf
					<div class="form-group">
						<textarea class="form-control" rows="8" placeholder="{{ __('admin_panel.users.message.placeholder') }}" id="message" name="message"></textarea>
						<p class="help-text mb-0 small text-muted">
							<span>{{ __('admin_panel.users.message.plainTextOnly') }}</span>
							<span class="float-right msg-counter"><span class="msg-count">0</span>/500</span>
						</p>
					</div>
					<p class="float-right">
						<button type="button" class="btn btn-primary py-1 font-weight-bold" onclick="submitWarning()"><i class="fas fa-message"></i> {{ __('admin_panel.users.message.send') }}</button>
					</p>
				</form>
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
	function submitWarning() {
		let msg = document.querySelector('#message');
		if(msg.value.length < 5) {
			swal(@json(__('admin_panel.users.message.oops')), @json(__('admin_panel.users.message.tooShort')), 'error');
			return;
		}
		if(msg.value.length > 500) {
			swal(@json(__('admin_panel.users.message.oops')), @json(__('admin_panel.users.message.tooLong')), 'error');
			return;
		}
		swal({
			title: @json(__('admin_panel.common.areYouSure')),
			text: @json(__('admin_panel.users.message.confirmSend', ['username' => $user->username])),
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((sendMessage) => {
			if (sendMessage) {
				$('#messageForm').submit();
			} else {
				return;
			}
		});
	}
</script>
@endpush