@extends('admin.partial.template')

@include('admin.settings.sidebar')

@section('section')
<div class="title">
	<h3 class="font-weight-bold">{{ __('admin_panel.settings.storage.title') }}</h3>
	<p class="lead">{{ __('admin_panel.settings.storage.subtitle') }}</p>
</div>
<hr>
<p class="alert alert-warning">
	<strong>{{ __('admin_panel.common.featureUnavailable') }}</strong> {{ __('admin_panel.common.futureVersion') }}
</p>
@endsection

@push('scripts')
<script type="text/javascript">
	$('.human-size').each(function(d,a) {
		let el = $(a);
		let size = el.data('bytes');
		el.text(filesize(size, {round: 0}));
	});
</script>
@endpush
