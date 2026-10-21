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

    @if(Auth::user()->email_verified_at)
    	<p class="lead text-center mt-5">{!! __('pages.account.verifyEmail.alreadyVerified', ['link' => '<a href="/" class="font-weight-bold">'.e(__('pages.common.clickHere')).'</a>']) !!}</p>
    @else
    <div class="card shadow-none border">
      <div class="card-header font-weight-bold bg-white">{{ __('pages.account.verifyEmail.title') }}</div>
      <div class="card-body">
        <p class="lead text-break">{!! __('pages.account.verifyEmail.needConfirm', ['email' => '<span class="font-weight-bold">'.e(Auth::user()->email).'</span>']) !!}</p>
        @if(!$recentSent)
        <form method="post">
          @csrf
          <button type="submit" class="btn btn-primary btn-block py-1 font-weight-bold">{{ __('pages.account.verifyEmail.send') }}</button>
        </form>
        @else
        	<button class="btn btn-primary btn-block py-1 font-weight-bold" disabled>{{ __('pages.account.verifyEmail.sent') }}</button>
        @endif
    	<p class="mt-3 mb-0 small text-muted">{!! __('pages.account.verifyEmail.changeEmail', ['link' => '<a href="/settings/email" class="font-weight-bold">'.e(__('pages.common.clickHere')).'</a>']) !!}</p>
      </div>
    </div>

    @if($recentSent)
    <div class="card mt-3 border shadow-none">
    	<div class="card-body">
    		<p class="mb-0 text-muted">{!! __('pages.account.verifyEmail.manualHint', ['link' => '<a href="/i/verify-email/request" class="font-weight-bold">'.e(__('pages.account.verifyEmail.requestManual')).'</a>']) !!}</p>
    	</div>
    </div>
    @endif

    @endif
  </div>
</div>
@endsection
