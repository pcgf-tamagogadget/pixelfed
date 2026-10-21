@extends('settings.template')

@section('section')

<div class="title">
	<h3 class="font-weight-bold">{{ __('settings.applications') }}</h3>
</div>
<hr>
@if((bool) config_cache('pixelfed.oauth_enabled') == true)
	<passport-authorized-clients></passport-authorized-clients>
	<passport-personal-access-tokens :pat-enabled="{{ config_cache('instance.oauth.pat_enabled') ? 'true' : 'false' }}"></passport-personal-access-tokens>
@else
	<p class="lead">{{ __('settings.developers.oauth_has_not_been_enabled_on_this_instance') }}</p>
@endif
@endsection

@push('scripts')
<script type="text/javascript" src="{{mix('js/developers.js')}}"></script>
@endpush
