@extends('portfolio.layout')

@section('content')
<div class="container">
	<div class="row mt-5 pt-5">
		<div class="col-12 text-center">
			<p class="mb-5">
				<span class="logo-mark px-3"><span class="text-gradient-primary">portfolio</span></span>
			</p>

            <h1>{{ __('pages.portfolio.notFound') }}</h1>

			<p class="lead pt-3 mb-4">{{ __('pages.portfolio.notFoundBody') }}</p>

			<p class="mt-3">
				<a href="{{ config('app.url') }}" class="text-muted" style="text-decoration: underline;">{{ __('pages.portfolio.goHome') }}</a>
			</p>
		</div>
	</div>
</div>
@endsection
