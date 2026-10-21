@extends('admin.partial.template-full')

@section('section')
	<div class="bg-primary px-4 py-3 mb-5 rounded d-flex align-items-center justify-content-between">
		<div style="max-width: 70%;">
			<p class="lead text-white my-0 font-weight-bold">{{ __('admin_panel.reports.show.newUiTitle') }}</p>
			<p class="text-white small mb-0">{{ __('admin_panel.reports.show.newUiDescription') }}</p>
		</div>
		<a href="/i/admin/reports?tab=report&id={{$report->id}}" class="btn btn-outline-white">{{ __('admin_panel.reports.show.viewInNewUi') }}</a>
	</div>

	<div class="d-flex justify-content-between title mb-3">
		<div>
			<p class="font-weight-bold h3">
				{{ __('admin_panel.reports.show.title', ['id' => $report->id]) }} - 
				<span class="text-danger">{{ucfirst($report->type)}}</span>
			</p>
			<p class="text-muted mb-0 lead">
				{!! __('admin_panel.reports.show.reportedBy', ['time' => e($report->created_at->diffForHumans()), 'url' => e($report->reporter->url()), 'username' => e($report->reporter->username)]) !!}
			</p>
		</div>
	</div>

	<div class="row">
		<div class="col-12 col-md-8 mt-3">
			<div class="card shadow-none border">
				@if($report->status && $report->status->media()->count())
				<img class="card-img-top border-bottom" src="{{$report->status->thumb(true)}}">
				@endif
				<div class="card-body">
					<div class="mt-2 p-3">
						@if($report->status && $report->status->caption)
						<p class="text-break">
							{{ $report->status->media()->count() ? __('admin_panel.reports.show.caption') : __('admin_panel.reports.show.comment') }}: <span class="font-weight-bold">{{$report->status->caption}}</span>
						</p>
						@endif
						@if($report->status)
						<p class="mb-0">
							{{ __('admin_panel.reports.show.likeCount') }}: <span class="font-weight-bold">{{$report->status->likes_count}}</span>
						</p>
						<p class="mb-0">
							{{ __('admin_panel.reports.show.shareCount') }}: <span class="font-weight-bold">{{$report->status->reblogs_count}}</span>
						</p>
						<p class="mb-0">
							{{ __('admin_panel.reports.show.timestamp') }}: <span class="font-weight-bold">{{now()->parse($report->status->created_at)->format('r')}}</span>
						</p>
						<p class="mb-0" style="word-break: break-all !important;">
							{{ __('admin_panel.reports.show.originalUrl') }}: <span class="font-weight-bold text-primary"><a href="/i/web/post/{{$report->status->id}}">{{$report->status->url()}}</a></span>
						</p>
                        <p class="" style="word-break: break-all !important;">
                            {{ __('admin_panel.reports.show.localUrl') }}: <span class="font-weight-bold text-primary"><a href="/i/web/post/{{$report->status->id}}">{{url('/i/web/post/' . $report->status->id)}}</a></span>
                        </p>
                        @endif
                        @if($report->status && $report->status->in_reply_to_id)
                        <p class="mt-n3" style="word-break: break-all !important;">
                            {{ __('admin_panel.reports.show.parentPost') }}: <span class="font-weight-bold text-primary"><a href="/i/web/post/{{$report->status->in_reply_to_id}}">{{url('/i/web/post/' . $report->status->in_reply_to_id)}}</a></span>
                        </p>
                        @endif
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-4 mt-3">
			<button type="button" class="btn btn-primary btn-block font-weight-bold mb-3 report-action-btn" data-action="cw">{{ __('admin_panel.reports.show.applyContentWarning') }}</button>
			<button type="button" class="btn btn-primary btn-block font-weight-bold mb-3 report-action-btn" data-action="unlist">{{ __('admin_panel.reports.show.unlistPost') }}</button>
			<button type="button" class="btn btn-light border btn-block font-weight-bold mb-3 report-action-btn" data-action="ignore">{{ __('admin_panel.reports.show.ignore') }}</button>

			<div class="card shadow-none border mt-5">
				<div class="card-header text-center font-weight-bold bg-light">
					{{ __('admin_panel.reports.show.userStats', ['username' => $report->reportedUser->username]) }}
				</div>
				<div class="card-body">
					<p>
						{{ __('admin_panel.reports.show.totalReports') }}: <span class="font-weight-bold text-danger">{{App\Report::whereReportedProfileId($report->reportedUser->id)->count()}}</span>
					</p>
					<p>
						{{ __('admin_panel.reports.show.totalWarnings') }}: <span class="font-weight-bold text-danger">{{App\AccountInterstitial::whereUserId($report->reportedUser->user_id)->count()}}</span>
					</p>
					<p class="">
						{{ __('admin_panel.reports.show.statusCount') }}: <span class="font-weight-bold">{{$report->reportedUser->status_count}}</span>
					</p>
					<p class="">
						{{ __('admin_panel.reports.show.followerCount') }}: <span class="font-weight-bold">{{$report->reportedUser->followers_count}}</span>
					</p>
					<p class="mb-0">
						{{ __('admin_panel.reports.show.joined') }}: <span class="font-weight-bold">{{$report->reportedUser->created_at->diffForHumans(null, null, false)}}</span>
					</p>
				</div>
			</div>

			<div class="card shadow-none border mt-5">
				<div class="card-header text-center font-weight-bold bg-light">
					{{ __('admin_panel.reports.show.userStats', ['username' => '@' . $report->reporter->username]) }}
				</div>
				<div class="card-body">
					<p class="">
						{{ __('admin_panel.reports.show.statusCount') }}: <span class="font-weight-bold">{{$report->reporter->status_count}}</span>
					</p>
					<p class="">
						{{ __('admin_panel.reports.show.followerCount') }}: <span class="font-weight-bold">{{$report->reporter->followers_count}}</span>
					</p>
					<p class="mb-0">
						{{ __('admin_panel.reports.show.joined') }}: <span class="font-weight-bold">{{$report->reporter->created_at->diffForHumans(null, null, false)}}</span>
					</p>
				</div>
			</div>

		</div>
	</div>
@endsection

@push('scripts')
<script type="text/javascript">
	$(document).on('click', '.report-action-btn', function(e) {
		e.preventDefault();
		let el = $(this);
		let action = el.data('action');
		axios.post(window.location.href, {
			'action': action
		})
		.then(function(res) {
			swal(@json(__('admin_panel.reports.show.success')), @json(__('admin_panel.reports.show.issueUpdated')), 'success');
			window.location.href = '/i/admin/reports';
		}).catch(function(res) {
			swal(@json(__('admin_panel.reports.show.error')), res.data.msg, 'error');
		});
	})
</script>
@endpush
