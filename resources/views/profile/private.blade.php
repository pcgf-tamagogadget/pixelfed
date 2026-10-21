@extends('layouts.app-guest',['title' => __('profile.page.userOnApp', ['username' => $user->username, 'app' => config_cache('app.name')])])

@section('content')
@if (session('error'))
		<div class="alert alert-danger text-center font-weight-bold mb-0">
				{{ session('error') }}
		</div>
@endif
@include('profile.partial.private-info')
@if($user->website)
<a class="d-none" href="{{$user->website}}" rel="me external nofollow noopener">{{$user->website}}</a>
@endif
<div class="container">
	<div class="profile-timeline mt-2 mt-md-4">
		<div class="">
			<div class="py-5">
				<p class="text-center lead font-weight-bold">
					{{__('profile.privateProfileWarning')}}
				</p>

				@if(!Auth::check())
				<p class="text-center mb-0">{{ __('profile.alreadyFollow', ['username'=>$user->username])}}</p>
				<p class="text-center mb-0"><a href="{{route('login')}}">{{ __('profile.page.logIn') }}</a></p>
				<p class="text-center mb-0">{{__('profile.loginToSeeProfile')}}</p>
				@endif
			</div>
		</div>
	</div>
</div>

@endsection

@push('meta')
<meta name="robots" content="noindex, nofollow">
@endpush
