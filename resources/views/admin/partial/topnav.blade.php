<nav class="navbar navbar-expand-lg navbar-light">
	<div class="container">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#topbarNav" aria-controls="topbarNav" aria-expanded="false" aria-label="{{ __('admin_panel.nav.toggleNavigation') }}">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="topbarNav">
			<ul class="navbar-nav">
				<li class="nav-item mx-4 {{request()->is('*admin/dashboard')?'active':''}}">
					<a class="nav-link" href="{{route('admin.home')}}">{{ __('admin_panel.nav.dashboard') }}</a>
				</li>
				{{--<li class="nav-item mx-2 {{request()->is('*messages*')?'active':''}}">
					<a class="nav-link font-weight-lighter text-muted" href="{{route('admin.messages')}}">Configuration</a>
				</li>
				<li class="nav-item mx-2 {{request()->is('*messages*')?'active':''}}">
					<a class="nav-link font-weight-lighter text-muted" href="{{route('admin.messages')}}">Content</a>
				</li>
				<li class="nav-item mx-2 {{request()->is('*messages*')?'active':''}}">
					<a class="nav-link font-weight-lighter text-muted" href="{{route('admin.messages')}}">Federation</a>
				</li>
				<li class="nav-item mx-2 {{request()->is('*messages*')?'active':''}}">
					<a class="nav-link font-weight-lighter text-muted" href="{{route('admin.messages')}}">Moderation</a>
				</li>
				<li class="nav-item mx-2 {{request()->is('*messages*')?'active':''}}">
					<a class="nav-link font-weight-lighter text-muted" href="{{route('admin.messages')}}">Platform</a>
				</li>
				<li class="nav-item mx-2 align-self-center text-lighter">|</li>
				<li class="nav-item mx-2 {{request()->is('*messages*')?'active':''}}">
					<a class="nav-link font-weight-lighter text-muted" href="{{route('admin.messages')}}">Media</a>
				</li>
				<li class="nav-item mx-2 {{request()->is('*messages*')?'active':''}}">
					<a class="nav-link font-weight-lighter text-muted" href="{{route('admin.messages')}}">Profiles</a>
				</li>
				<li class="nav-item mx-2 {{request()->is('*messages*')?'active':''}}">
					<a class="nav-link font-weight-lighter text-muted" href="{{route('admin.messages')}}">Statuses</a>
				</li> --}}
				<li class="nav-item mx-4 {{request()->is('*messages*')?'active':''}}">
					<a class="nav-link font-weight-lighter text-muted" href="{{route('admin.messages')}}">{{ __('admin_panel.nav.messages') }}</a>
				</li>
				{{-- <li class="nav-item mx-4 {{request()->is('*instances*')?'active':''}}">
					<a class="nav-link font-weight-lighter text-muted" href="{{route('admin.instances')}}">Instances</a>
				</li> --}}
				<li class="nav-item mx-4 {{request()->is('*reports*')?'active':''}}">
					<a class="nav-link font-weight-lighter text-muted" href="{{route('admin.reports')}}">{{ __('admin_panel.nav.moderation') }}</a>
				</li>
				{{-- <li class="nav-item mx-2 {{request()->is('*profiles*')?'active':''}}">
					<a class="nav-link font-weight-lighter text-muted" href="{{route('admin.profiles')}}">Profiles</a>
				</li> --}}
				<li class="nav-item mx-4 {{request()->is('*statuses*')?'active':''}}">
					<a class="nav-link font-weight-lighter text-muted" href="{{route('admin.statuses')}}">{{ __('admin_panel.nav.statuses') }}</a>
				</li>
				<li class="nav-item mx-4 {{request()->is('*users*')?'active':''}}">
					<a class="nav-link font-weight-lighter text-muted" href="{{route('admin.users')}}">{{ __('admin_panel.nav.users') }}</a>
				</li>
				<li class="nav-item mx-4 {{request()->is('*settings*')?'active':''}}">
					<a class="nav-link font-weight-lighter text-muted" href="{{route('admin.settings')}}">{{ __('admin_panel.nav.settings') }}</a>
				</li>
				<li class="nav-item dropdown ml-3 {{request()->is(['*discover*', '*site-news*'])?'active':''}}">
					<a class="nav-link dropdown-toggle px-4" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						{{ __('admin_panel.nav.more') }}
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
						<a class="dropdown-item font-weight-bold {{request()->is('*apps*')?'active':''}}" href="{{route('admin.apps')}}">{{ __('admin_panel.nav.apps') }}</a>
						{{-- <a class="dropdown-item font-weight-bold {{request()->is('*discover*')?'active':''}}" href="{{route('admin.discover')}}">Discover</a> --}}
						<a class="dropdown-item font-weight-bold {{request()->is('*hashtags*')?'active':''}}" href="{{route('admin.hashtags')}}">{{ __('admin_panel.nav.hashtags') }}</a>
						<a class="dropdown-item font-weight-bold {{request()->is('*instances*')?'active':''}}" href="{{route('admin.instances')}}">{{ __('admin_panel.nav.instances') }}</a>
						<a class="dropdown-item font-weight-bold {{request()->is('*media*')?'active':''}}" href="{{route('admin.media')}}">{{ __('admin_panel.nav.media') }}</a>
						<a class="dropdown-item font-weight-bold {{request()->is('*site-news*')?'active':''}}" href="/i/admin/site-news">{{ __('admin_panel.nav.newsroom') }}</a>
						<a class="dropdown-item font-weight-bold {{request()->is('*profiles*')?'active':''}}" href="/i/admin/profiles">{{ __('admin_panel.nav.profiles') }}</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item font-weight-bold" href="/admin/horizon">Horizon</a>
						@if(config('pulse.enabled'))
						<a class="dropdown-item font-weight-bold" href="/{{ config('pulse.path', 'admin/pulse') }}">Pulse</a>
						@endif
					</div>
				</li>
			</ul>
		</div>
	</div>
</nav>

@push('styles')
<style type="text/css">
	#topbarNav .nav-item:hover {
		border-bottom: 2px solid #08d;
		margin-bottom: -7px;
	}
	#topbarNav .nav-item.active {
		border-bottom: 2px solid #08d;
		margin-bottom: -7px;
	}
	#topbarNav .nav-item.active .nav-link {
		font-weight: bold !important;
	}
</style>
@endpush
