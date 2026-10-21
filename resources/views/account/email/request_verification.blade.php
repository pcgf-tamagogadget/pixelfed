@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <div class="col-12 col-md-8 offset-md-2">
	@if (session('status'))
		<div class="alert alert-success">
			<p class="font-weight-bold mb-0">{{ session('status') }}</p>
		</div>
	@endif
	@if (session('error'))
		<div class="alert alert-danger">
			<p class="font-weight-bold mb-0">{{ session('error') }}</p>
		</div>
	@endif
	<div class="card shadow-none border">
	  <div class="card-header font-weight-bold bg-white">{{ __('pages.account.manualVerify.title') }}</div>
	  <div class="card-body">
	  	<p class="">{{ __('pages.account.manualVerify.intro') }}</p>

	  	<p class="font-weight-bold">{{ __('pages.account.manualVerify.warning') }}</p>

	  	<p>{{ __('pages.account.manualVerify.resetHint') }}</p>

	  	@if(!$exists)
	  	<form method="post">
          @csrf
          <button type="submit" class="btn btn-primary btn-block py-1 font-weight-bold">{{ __('pages.account.manualVerify.proceed') }}</button>
        </form>
        @else
        <button class="btn btn-primary btn-block py-1 font-weight-bold" disabled>{{ __('pages.account.manualVerify.sent') }}</button>
        @endif
	  </div>
  </div>
</div>
</div>
@endsection
