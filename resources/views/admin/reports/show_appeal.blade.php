@extends('admin.partial.template-full')

@section('section')
<div class="d-flex justify-content-between title mb-3">
	<div>
		<p class="font-weight-bold h3">{{ __('admin_panel.reports.showAppeal.title') }}</p>
		<p class="text-muted mb-0 lead">{!! __('admin_panel.reports.showAppeal.from', ['url' => e($appeal->user->url()), 'username' => e($appeal->user->username), 'time' => e($appeal->appeal_requested_at->diffForHumans())]) !!}</p>
	</div>
	<div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-8 mt-3">
		@if($appeal->type == 'post.cw')
		<div class="card shadow-none border">
			<div class="card-header bg-light h5 font-weight-bold py-4">{{ $appeal->has_media ? __('admin_panel.reports.showAppeal.cwAppliedPost') : __('admin_panel.reports.showAppeal.cwAppliedComment') }}</div>
			@if($appeal->has_media)
			<img class="card-img-top border-bottom" src="{{$appeal->status->thumb(true)}}">
			@endif
			<div class="card-body">
				<div class="mt-2 p-3">
					@if($meta->caption)
					<p class="text-break">
						{{ $appeal->has_media ? __('admin_panel.reports.showAppeal.caption') : __('admin_panel.reports.showAppeal.comment') }}: <span class="font-weight-bold">{{$meta->caption}}</span>
					</p>
					@endif
					<p class="mb-0">
						{{ __('admin_panel.reports.showAppeal.likeCount') }}: <span class="font-weight-bold">{{$meta->likes_count}}</span>
					</p>
					<p class="mb-0">
						{{ __('admin_panel.reports.showAppeal.shareCount') }}: <span class="font-weight-bold">{{$meta->reblogs_count}}</span>
					</p>
					<p class="mb-0">
						{{ __('admin_panel.reports.showAppeal.timestamp') }}: <span class="font-weight-bold">{{now()->parse($meta->created_at)->format('r')}}</span>
					</p>
					<p class="" style="word-break: break-all !important;">
						URL: <span class="font-weight-bold text-primary"><a href="{{$meta->url}}">{{$meta->url}}</a></span>
					</p>
					<p class="mb-0">
						{{ __('admin_panel.reports.showAppeal.message') }}: <span class="font-weight-bold">{{$appeal->appeal_message}}</span>
					</p>
				</div>
			</div>
		</div>
		@elseif($appeal->type == 'post.unlist')
		<div class="card shadow-none border">
			<div class="card-header bg-light h5 font-weight-bold py-4">{{ $appeal->has_media ? __('admin_panel.reports.showAppeal.postUnlisted') : __('admin_panel.reports.showAppeal.commentUnlisted') }}</div>
			@if($appeal->has_media)
			<img class="card-img-top border-bottom" src="{{$appeal->status->thumb(true)}}">
			@endif
			<div class="card-body">
				<div class="mt-2 p-3">
					@if($meta->caption)
					<p class="text-break">
						{{ $appeal->has_media ? __('admin_panel.reports.showAppeal.caption') : __('admin_panel.reports.showAppeal.comment') }}: <span class="font-weight-bold">{{$meta->caption}}</span>
					</p>
					@endif
					<p class="mb-0">
						{{ __('admin_panel.reports.showAppeal.likeCount') }}: <span class="font-weight-bold">{{$meta->likes_count}}</span>
					</p>
					<p class="mb-0">
						{{ __('admin_panel.reports.showAppeal.shareCount') }}: <span class="font-weight-bold">{{$meta->reblogs_count}}</span>
					</p>
					<p class="mb-0">
						{{ __('admin_panel.reports.showAppeal.timestamp') }}: <span class="font-weight-bold">{{now()->parse($meta->created_at)->format('r')}}</span>
					</p>
					<p class="" style="word-break: break-all !important;">
						URL: <span class="font-weight-bold text-primary"><a href="{{$meta->url}}">{{$meta->url}}</a></span>
					</p>
					<p class="mb-0">
						{{ __('admin_panel.reports.showAppeal.message') }}: <span class="font-weight-bold">{{$appeal->appeal_message}}</span>
					</p>
				</div>
			</div>
		</div>
		@endif
	</div>
	<div class="col-12 col-md-4 mt-3">
		<form method="post">
			@csrf
			<input type="hidden" name="action" value="dismiss">
			<button type="submit" class="btn btn-primary btn-block font-weight-bold mb-3">{{ __('admin_panel.reports.showAppeal.dismiss') }}</button>
		</form>
		<button type="button" class="btn btn-light border btn-block font-weight-bold mb-3" onclick="approveWarning()">{{ __('admin_panel.reports.showAppeal.approve') }}</button>
		<div class="card shadow-none border mt-5">
			<div class="card-header text-center font-weight-bold bg-light">
				{{ __('admin_panel.reports.showAppeal.userStats', ['username' => '@' . $appeal->user->username]) }}
			</div>
			<div class="card-body">
				<p class="">
					{{ __('admin_panel.reports.showAppeal.openAppeals') }}: <span class="font-weight-bold">{{App\AccountInterstitial::whereUserId($appeal->user_id)->whereNotNull('appeal_requested_at')->whereNull('appeal_handled_at')->count()}}</span>
				</p>
				<p class="">
					{{ __('admin_panel.reports.showAppeal.totalAppeals') }}: <span class="font-weight-bold">{{App\AccountInterstitial::whereUserId($appeal->user_id)->whereNotNull('appeal_requested_at')->count()}}</span>
				</p>
				<p class="">
					{{ __('admin_panel.reports.showAppeal.totalWarnings') }}: <span class="font-weight-bold">{{App\AccountInterstitial::whereUserId($appeal->user_id)->count()}}</span>
				</p>
				<p class="">
					{{ __('admin_panel.reports.showAppeal.statusCount') }}: <span class="font-weight-bold">{{$appeal->user->statuses()->count()}}</span>
				</p>
				<p class="mb-0">
					{{ __('admin_panel.reports.showAppeal.joined') }}: <span class="font-weight-bold">{{$appeal->user->created_at->diffForHumans(null, null, false)}}</span>
				</p>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
	function approveWarning() {
		if(window.confirm(@json(__('admin_panel.reports.showAppeal.confirmApprove'))) == true) {
			axios.post(window.location.href,  {
				action: 'approve'
			}).then(res => {
				window.location.href = '/i/admin/reports/appeals';
			}).catch(err => {
				swal(@json(__('admin_panel.reports.showAppeal.oops')), @json(__('admin_panel.reports.showAppeal.errorTryLater')), 'error');
			});
		}
	}
</script>
@endpush