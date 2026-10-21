@extends('admin.partial.template-full')

@section('section')
	<div class="bg-primary px-4 py-3 mb-5 rounded d-flex align-items-center justify-content-between">
		<div style="max-width: 70%;">
			<p class="lead text-white my-0 font-weight-bold">{{ __('admin_panel.reports.showSpam.newUiTitle') }}</p>
			<p class="text-white small mb-0">{{ __('admin_panel.reports.showSpam.newUiDescription') }}</p>
		</div>
		<a href="/i/admin/reports?tab=autospam&id={{$appeal->id}}" class="btn btn-outline-white">{{ __('admin_panel.reports.showSpam.viewInNewUi') }}</a>
	</div>
<div class="d-flex justify-content-between title mb-3">
	<div>
		<p class="font-weight-bold h3">{{ __('admin_panel.reports.showSpam.title') }}</p>
		<p class="text-muted mb-0 lead">{!! __('admin_panel.reports.showSpam.detected', ['time' => e($appeal->created_at->diffForHumans()), 'url' => e($appeal->user->url()), 'username' => e($appeal->user->username)]) !!}</p>
	</div>
	<div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-8 mt-3">
		@if($appeal->type == 'post.autospam')
		<div class="card shadow-none border">
			<div class="card-header bg-light h5 font-weight-bold py-4">{{ __('admin_panel.reports.showSpam.unlistedContentWarning') }}</div>
			@if($appeal->has_media)
			<img class="card-img-top border-bottom" src="{{$appeal->status->thumb(true)}}" style="max-height: 40vh;object-fit: contain;" onerror="this.onerror=null;this.src='/storage/no-preview.png?v=0'">
			@endif
			<div class="card-body">
				<div class="mt-2 p-3">
					@if($meta->caption)
					<p class="text-break">
						{{ $appeal->has_media ? __('admin_panel.reports.showSpam.caption') : __('admin_panel.reports.showSpam.comment') }}: <span class="font-weight-bold">{{$meta->caption}}</span>
					</p>
					@endif
					<p class="mb-0">
						{{ __('admin_panel.reports.showSpam.likeCount') }}: <span class="font-weight-bold">{{$meta->likes_count}}</span>
					</p>
					<p class="mb-0">
						{{ __('admin_panel.reports.showSpam.shareCount') }}: <span class="font-weight-bold">{{$meta->reblogs_count}}</span>
					</p>
					<p class="mb-0">
						{{ __('admin_panel.reports.showSpam.timestamp') }}: <span class="font-weight-bold">{{now()->parse($meta->created_at)->format('r')}}</span>
					</p>
					<p class="" style="word-break: break-all !important;">
						URL: <span class="font-weight-bold text-primary"><a href="/i/web/post/{{$appeal->item_id}}" target="_blank">{{$meta->url}}</a></span>
					</p>
				</div>
			</div>
		</div>
		@endif
	</div>
	<div class="col-12 col-md-4 mt-3">
		@if($appeal->appeal_handled_at)
		@else
		<button type="button" class="btn btn-primary border btn-block font-weight-bold mb-3 action-btn" data-action="dismiss">{{ __('admin_panel.reports.showSpam.markAsRead') }}</button>
		<button type="button" class="btn btn-light border btn-block font-weight-bold mb-3 action-btn" data-action="approve">{{ __('admin_panel.reports.showSpam.markAsNotSpam') }}</button>
		<hr>
		<button type="button" class="btn btn-default border btn-block font-weight-bold mb-3 action-btn" data-action="dismiss-all">{{ __('admin_panel.reports.showSpam.markAllAsRead') }}</button>
		<button type="button" class="btn btn-light border btn-block font-weight-bold mb-3 action-btn" data-action="approve-all">{{ __('admin_panel.reports.showSpam.markAllAsNotSpam') }}</button>
		<hr>
		<button type="button" class="btn btn-light border btn-block font-weight-bold mb-3 action-btn" data-action="mark-spammer">{{ __('admin_panel.reports.showSpam.markAsSpammer') }}</button>
		<button type="button" class="btn btn-danger border btn-block font-weight-bold mb-3 action-btn mb-5" data-action="delete-account">{{ __('admin_panel.reports.showSpam.deleteAccount') }}</button>
		@endif
		<div class="card shadow-none border">
			<div class="card-header text-center font-weight-bold bg-light">
				{{ __('admin_panel.reports.showSpam.userStats', ['username' => '@' . $appeal->user->username]) }}
			</div>
			<div class="card-body">
				<p class="">
					{{ __('admin_panel.reports.showSpam.openAppeals') }}: <span class="font-weight-bold">{{App\AccountInterstitial::whereUserId($appeal->user_id)->whereNotNull('appeal_requested_at')->whereNull('appeal_handled_at')->count()}}</span>
				</p>
				<p class="">
					{{ __('admin_panel.reports.showSpam.totalAppeals') }}: <span class="font-weight-bold">{{App\AccountInterstitial::whereUserId($appeal->user_id)->whereNotNull('appeal_requested_at')->count()}}</span>
				</p>
				<p class="">
					{{ __('admin_panel.reports.showSpam.totalWarnings') }}: <span class="font-weight-bold">{{App\AccountInterstitial::whereUserId($appeal->user_id)->count()}}</span>
				</p>
				<p class="">
					{{ __('admin_panel.reports.showSpam.statusCount') }}: <span class="font-weight-bold">{{$appeal->user->statuses()->count()}}</span>
				</p>
				<p class="mb-0">
					{{ __('admin_panel.reports.showSpam.joined') }}: <span class="font-weight-bold">{{$appeal->user->created_at->diffForHumans(null, null, false)}}</span>
				</p>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
	$('.action-btn').click((e) => {
		e.preventDefault();
		e.currentTarget.blur();

		let type = e.currentTarget.getAttribute('data-action');

		switch(type) {
			case 'dismiss':
			break;

			case 'approve':
				if(!window.confirm(@json(__('admin_panel.reports.showSpam.confirmApprove')))) {
					return;
				}
			break;

			case 'dismiss-all':
				if(!window.confirm(@json(__('admin_panel.reports.showSpam.confirmDismissAll')))) {
					return;
				}
			break;

			case 'approve-all':
				if(!window.confirm(@json(__('admin_panel.reports.showSpam.confirmApproveAll')))) {
					return;
				}
			break;

			case 'mark-spammer':
				if(!window.confirm(@json(__('admin_panel.reports.showSpam.confirmMarkSpammer')))) {
					return;
				}
			break;

			case 'delete-account':
				if(!window.confirm(@json(__('admin_panel.reports.showSpam.confirmDeleteAccount')))) {
					return;
				}
			break;
		}

		axios.post(window.location.href, {
			action: type
		}).then(res => {
			location.href = '/i/admin/reports/autospam';
		}).catch(err => {
			swal(@json(__('admin_panel.reports.showSpam.oops')), @json(__('admin_panel.reports.showSpam.errorOccurred')), 'error');
			console.log(err);
		})
	});
</script>
@endpush
