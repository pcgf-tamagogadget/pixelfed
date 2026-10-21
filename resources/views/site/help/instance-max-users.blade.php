@extends('site.help.partial.template', ['breadcrumb'=>__('helpcenter.instanceMaxUsers.title')])

@section('section')

	<div class="title">
		<h3 class="font-weight-bold">{{ __('helpcenter.instanceMaxUsers.title') }}</h3>
	</div>
	<hr>
	@if(config('pixelfed.max_users'))
	<p class="lead">{{ __('helpcenter.instanceMaxUsers.limitP1') }}</p>

	<p class="lead">{{ __('helpcenter.instanceMaxUsers.limitP2') }}</p>

	<p class="lead">{!! __('helpcenter.instanceMaxUsers.limitP3') !!}</p>
	@else
	<p class="lead">{{ __('helpcenter.instanceMaxUsers.noLimitP1') }}</p>

	<p class="lead">{!! __('helpcenter.instanceMaxUsers.noLimitP2') !!}</p>
	@endif
@endsection
