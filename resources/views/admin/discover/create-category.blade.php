@extends('admin.partial.template-full')

@section('section')
<div class="title">
	<h3 class="font-weight-bold d-inline-block">{{ __('admin_panel.discover.createCategory.title') }}</h3>
	<p class="lead">{{ __('admin_panel.discover.createCategory.subtitle') }}</p>
</div>

<hr>

<form class="px-md-5 cc-form" method="post">
	<div class="form-group row">
		<label for="categoryName" class="col-sm-2 col-form-label font-weight-bold">{{ __('admin_panel.discover.createCategory.name') }}</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="categoryName" placeholder="{{ __('admin_panel.discover.createCategory.namePlaceholder') }}" autocomplete="off">
			<p class="form-text small font-weight-bold text-muted">{{ __('admin_panel.discover.createCategory.slug', ['path' => '/discover/c/nature']) }}</p>
		</div>
	</div>
	<div class="form-group row">
		<label for="categoryName" class="col-sm-2 col-form-label font-weight-bold">{{ __('admin_panel.discover.createCategory.mediaId') }}</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="categoryMedia" placeholder="1" autocomplete="off">
			<p class="form-text small font-weight-bold text-muted">{{ __('admin_panel.discover.createCategory.mediaIdHelp') }}</p>
		</div>
	</div>
	<div class="form-group row">
		<label for="categoryActive" class="col-sm-2 col-form-label font-weight-bold">{{ __('admin_panel.discover.createCategory.active') }}</label>
		<div class="col-sm-10">
			<div class="custom-control custom-switch pt-2">
				<input type="checkbox" class="custom-control-input" id="categoryActive">
				<label class="custom-control-label" for="categoryActive"></label>
			</div>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label font-weight-bold">{{ __('admin_panel.discover.createCategory.rules') }}</label>
		<div class="col-sm-10">
			<div class="custom-control custom-switch pt-2">
				<input type="checkbox" class="custom-control-input" id="categoryNsfw">
				<label class="custom-control-label" for="categoryNsfw">{{ __('admin_panel.discover.createCategory.allowNsfw') }}</label>
			</div>
			<div class="custom-control custom-switch pt-2">
				<input type="checkbox" class="custom-control-input" id="categoryNsfw">
				<label class="custom-control-label" for="categoryType">{{ __('admin_panel.discover.createCategory.allowPhotosVideo') }}</label>
			</div>
		</div>
	</div>
	<hr>
	<div class="form-group">
		<div class="text-right">
			<button type="submit" class="btn btn-primary btn-sm py-1 font-weight-bold">{{ __('admin_panel.common.create') }}</button>
		</div>
	</div>
</form>

@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
	$('.cc-form').on('submit', function(e) {
		e.preventDefault();
		let data = {
			'name': document.getElementById('categoryName').value,
			'media': document.getElementById('categoryMedia').value,
			'active': document.getElementById('categoryActive').checked
		};

		axios.post('{{request()->url()}}', data)
		.then(res => {
			window.location.href = '{{route('admin.discover')}}';
		});
	})
});
</script>
@endpush