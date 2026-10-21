@extends('layouts.blank')

@section('content')
<div style="width:100%;height:100vh;" class="d-flex justify-content-center align-items-center">
	<div class="text-center">
		<img src="/img/pixelfed-icon-grey.svg">
		<p class="mt-3 py-4">{!! __('site.redirect.redirectingTo', ['url' => e($url)]) !!}</p>
		<div class="spinner-border text-lighter" role="status">
			<span class="sr-only">{{ __('web.common.loading') }}</span>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
	 window.history.replaceState({}, document.title, '/i/redirect');
		setTimeout(function() {
		window.location.href = {{ Js::from($url) }};
	 }, 1500);
</script>
@endpush
