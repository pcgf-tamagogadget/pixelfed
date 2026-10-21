@extends('layouts.app')

@section('content')
<div class="container">
  <div class="error-page py-5 my-5">
  	<div class="text-center">
		<h3 class="font-weight-bold">{{ __('pages.errors.somethingWrong') }}</h3>
		<p class="lead py-3">{{ __('pages.errors.cannotProcess') }}</p>
		<p class="mb-0">
			<a href="/" class="btn btn-primary font-weight-bold">{{ __('pages.errors.backToTimeline') }}</a>
		</p>
  	</div>
  	@if($exception && $exception->getMessage())
  	<hr>
    <p class="text-center small payload text-uppercase font-weight-bold text-primary cursor-pointer" data-payload="{{encrypt('exception_report:'.$exception->getMessage()) ?? ''}}">
    	{{ __('pages.errors.copyDiagnostic') }}
    </p>
    @endif
  </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
	let payload = document.querySelector('.payload').getAttribute('data-payload');

	$('.payload').click(function(e) {
		try {
			App.util.clipboard(payload);
			swal(
				@json(__('pages.errors.copied')),
				@json(__('pages.errors.copiedBody')),
				'success'
			);
		} catch {
			swal(
				@json(__('pages.errors.diagnosticDetails')),
				payload,
				'info'
			);
		}
	});
</script>
@endpush
