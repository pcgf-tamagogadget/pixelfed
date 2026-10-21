@extends('admin.partial.template-full')

@section('section')
<div class="row">
	<div class="col-12">
		<div class="d-flex justify-content-between align-items-center">

			<div class="title">
				<p class="h1 font-weight-bold">{{ __('admin_panel.newsroom.create.title') }}</p>
				<p class="lead mb-0">{{ __('admin_panel.newsroom.create.subtitle') }}</p>
			</div>
			<div>
				<a class="btn btn-outline-secondary px-2" style="font-size:13px;" href="{{route('admin.newsroom.home')}}"><i class="fas fa-chevron-left fa-sm text-lighter mr-1"></i> {{ __('admin_panel.newsroom.create.backToNewsroom') }} </a>
			</div>
		</div>
		<hr>
	</div>
	<div class="col-md-7 border-right">
		<div>
			<form method="post">
				@csrf
				<div class="form-group">
					<label for="title" class="small font-weight-bold text-muted text-uppercase">{{ __('admin_panel.newsroom.create.fieldTitle') }}</label>
					<input type="text" class="form-control" id="title" name="title">
					<p class="help-text mb-0 small font-weight-bold text-lighter">{{ __('admin_panel.newsroom.create.titleHelp') }}</p>
				</div>
				<div class="form-group">
					<label for="summary" class="small font-weight-bold text-muted text-uppercase">{{ __('admin_panel.newsroom.create.summary') }}</label>
					<textarea class="form-control" id="summary" name="summary" rows="3"></textarea>
				</div>
				<div class="form-group">
					<label for="body" class="small font-weight-bold text-muted text-uppercase">{{ __('admin_panel.newsroom.create.body') }}</label>
					<textarea class="form-control" id="body" name="body" rows="6"></textarea>
					<p class="help-text mb-0 small font-weight-bold text-lighter">{!! __('admin_panel.newsroom.create.bodyHelp') !!}</p>
				</div>
				<div class="form-group">
					<label for="category" class="small font-weight-bold text-muted text-uppercase">{{ __('admin_panel.newsroom.create.category') }}</label>
					<input type="text" class="form-control" id="category" name="category" value="update">
				</div>
			</div>

		</div>
		<div class="col-md-5">
			<label class="small font-weight-bold text-muted text-uppercase">{{ __('admin_panel.newsroom.create.preview') }}</label>
			<div class="card border shadow-none mb-3">
				<div class="card-body">
					<div class="card-title mb-0">
						<span class="font-weight-bold" id="preview_title">{{ __('admin_panel.newsroom.create.untitled') }}</span>
						<span class="float-right cursor-pointer" title="{{ __('admin_panel.common.close') }}"><i class="fas fa-times text-lighter"></i></span>
					</div>
					<p class="card-text">
						<span style="font-size:13px;" id="preview_summary">{{ __('admin_panel.newsroom.create.addSummary') }}</span>
					</p>
					<p class="d-flex align-items-center justify-content-between mb-0">
						<a href="#" class="small font-weight-bold mb-0">{{ __('admin_panel.newsroom.create.readMore') }}</a>
						<span>
							<span class="btn btn-outline-secondary btn-sm py-0 disabled">
								<i class="fas fa-chevron-left fa-sm"></i>
							</span>
							<span class="btn btn-outline-success btn-sm py-0 mx-1" title="{{ __('admin_panel.newsroom.create.markAsRead') }}" data-toggle="tooltip" data-placement="bottom">
								<i class="fas fa-check fa-sm"></i>
							</span>
							<span class="btn btn-outline-secondary btn-sm py-0">
								<i class="fas fa-chevron-right fa-sm"></i>
							</span>
						</span>
					</p>
				</div>
			</div>
			<hr>
			<p class="mt-3">
				<button type="submit" class="btn btn-primary btn-block font-weight-bold py-1 px-4">{{ __('admin_panel.common.save') }}</button>
			</p>
			<div class="form-group">
				<div class="custom-control custom-switch">
					<input type="checkbox" class="custom-control-input" id="published" name="published">
					<label class="custom-control-label font-weight-bold text-uppercase text-muted" for="published">{{ __('admin_panel.newsroom.create.published') }}</label>
				</div>
			</div>  
			<div class="form-group">
				<div class="custom-control custom-switch">
					<input type="checkbox" class="custom-control-input" id="show_timeline" name="show_timeline">
					<label class="custom-control-label font-weight-bold text-uppercase text-muted" for="show_timeline">{{ __('admin_panel.newsroom.create.showOnTimelines') }}</label>
				</div>
			</div>  
			<div class="form-group">
				<div class="custom-control custom-switch">
					<input type="checkbox" class="custom-control-input" id="auth_only" name="auth_only">
					<label class="custom-control-label font-weight-bold text-uppercase text-muted" for="auth_only">{{ __('admin_panel.newsroom.create.loggedInOnly') }}</label>
				</div>
			</div>  
			<div class="form-group">
				<div class="custom-control custom-switch">
					<input type="checkbox" class="custom-control-input" id="show_link" name="show_link">
					<label class="custom-control-label font-weight-bold text-uppercase text-muted" for="show_link">{{ __('admin_panel.newsroom.create.showReadMoreLink') }}</label>
				</div>
			</div>  
{{-- <div class="form-group">
<div class="custom-control custom-switch">
<input type="checkbox" class="custom-control-input" id="force_modal" name="force_modal">
<label class="custom-control-label font-weight-bold text-uppercase text-muted" for="force_modal">Show Modal on timelines</label>
</div>
</div> --}}
</form>
</div>
</div>
<form id="delete-form" method="post">
	@method('delete')
	@csrf
</form>
@endsection

@push('scripts')
<script type="text/javascript">
	$('#title').on('change keyup paste',function(e) {
		let el = $(this);
		let title = el.val()
		$('#preview_title').text(title);
	});

	$('#summary').on('change keyup paste',function(e) {
		let el = $(this);
		let title = el.val()
		$('#preview_summary').text(title);
	});

	$('#btn-delete').on('click', function(e) {
		e.preventDefault();
		if(window.confirm(@json(__('admin_panel.newsroom.create.confirmDelete'))) == true) {
			document.getElementById('delete-form').submit();
		}
	})

</script>
@endpush