<p>{{ __('settings.two_factor.description') }} <a href="#">{{ __('settings.two_factor.learn_more') }}</a>.</p>
<div class="card mb-3">
	<div class="card-header bg-light">
		<span class="font-weight-bold">
			{{ __('settings.two_factor.two_factor_methods') }}
		</span>
	</div>
	<ul class="list-group list-group-flush">
		<li class="list-group-item">
			<div class="d-flex justify-content-between align-items-center py-2">
				<div>{{ __('settings.two_factor.authenticator_app') }}</div>
				<div><a class="btn btn-secondary btn-sm font-weight-bold" href="{{route('settings.security.2fa.edit')}}">{{ __('settings.two_factor.edit') }}</a></div>
			</div>
		</li>
	</ul>
</div><div class="card mb-3">
	<div class="card-header bg-light">
		<span class="font-weight-bold">
			{{ __('settings.two_factor.recovery_options') }}
		</span>
	</div>
	<ul class="list-group list-group-flush">
		<li class="list-group-item">
			<div class="d-flex justify-content-between align-items-center py-2">
				<div>{{ __('settings.two_factor.recovery_codes') }}</div>
				<div><a class="btn btn-secondary btn-sm font-weight-bold" href="{{route('settings.security.2fa.recovery')}}">{{ __('settings.two_factor.view') }}</a></div>
			</div>
		</li>
	</ul>
</div>