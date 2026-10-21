<ul class="list-group">
	<li class="list-group-item bg-light">
		<div class="text-center py-5 px-4">
			<p class="text-muted">
				<i class="fas fa-lock fa-2x"></i>
			</p>
			<p class="text-muted h4 font-weight-bold">
				{{ __('settings.two_factor.not_enabled_yet') }}
			</p>
			<p class="text-muted">
				{{ __('settings.two_factor.description') }}
			</p>
			<p class="mb-0">
				<a class="btn btn-success font-weight-bold" href="{{route('settings.security.2fa.setup')}}">{{ __('settings.two_factor.enable_two_factor_authentication') }}</a>
			</p>
		</div>
	</li>
</ul>
