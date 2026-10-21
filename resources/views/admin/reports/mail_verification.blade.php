@extends('admin.partial.template-full')

@section('section')
	<div class="title mb-3 d-flex justify-content-between align-items-center">
		<div>
			<h3 class="font-weight-bold d-inline-block">{{ __('admin_panel.reports.mailVerification.title') }}</h3>
			@if($ignored)
				<p>
					{!! __('admin_panel.reports.mailVerification.ignoringCount', ['count' => e(count($ignored))]) !!} <a href="#" class="font-weight-bold clear-ignored">{{ __('admin_panel.reports.mailVerification.clearIgnored') }}</a>
				</p>
			@endif
		</div>
		<div class="float-right">
		</div>
	</div>
	<div class="col-12 col-md-8 offset-md-2">
		<div class="card shadow-none border">
			<div class="list-group list-group-flush">
				@foreach($reports as $report)
				<div class="list-group-item">
					<div class="media align-items-center">
						<img src="{{ $report['avatar'] }}" width="50" height="50" class="rounded-circle border mr-3">
						<div class="media-body">
							<p class="font-weight-bold mb-0">{{ $report['username'] }}</p>
							<p class="text-muted mb-0">{{ $report['email'] }}</p>
						</div>
						<div>
							<button class="action-btn btn btn-light font-weight-bold mr-2" data-action="ignore" data-id="{{$report['id']}}">{{ __('admin_panel.reports.mailVerification.ignore') }}</button>
							<button class="action-btn btn btn-primary font-weight-bold" data-action="approve" data-id="{{$report['id']}}"><i class="far fa-check-circle fa-lg mr-2"></i>{{ __('admin_panel.reports.mailVerification.approve') }}</button>
						</div>
					</div>
				</div>
				@endforeach

				@if(count($reports) == 0)
				<div class="list-group-item">
					<p class="font-weight-bold mb-0">{{ __('admin_panel.reports.mailVerification.empty') }}</p>
				</div>
				@endif
			</div>
		</div>
	</div>
@endsection

@push('scripts')
<script type="text/javascript">
	$('.clear-ignored').click((e) => {
		e.preventDefault();
		if(!window.confirm(@json(__('admin_panel.reports.mailVerification.confirmClearIgnored')))) {
			return;
		}
		axios.post('/i/admin/reports/email-verifications/clear-ignored')
		.then(res => {
			location.reload();
		});
	});

	$('.action-btn').click((e) => {
		e.preventDefault();
		let type = e.currentTarget.getAttribute('data-action');
		let id = e.currentTarget.getAttribute('data-id');
		const confirmMessages = {
			ignore: @json(__('admin_panel.reports.mailVerification.confirmIgnore')),
			approve: @json(__('admin_panel.reports.mailVerification.confirmApprove'))
		};
		if(!window.confirm(confirmMessages[type])) {
			return;
		}
		axios.post('/i/admin/reports/email-verifications/' + type, {
			id: id
		}).then(res => {
			location.href = '/i/admin/reports';
		}).catch(err => {
			swal(@json(__('admin_panel.reports.mailVerification.oops')), @json(__('admin_panel.reports.mailVerification.errorOccurred')), 'error');
			console.log(err);
		})
	});
</script>
@endpush
