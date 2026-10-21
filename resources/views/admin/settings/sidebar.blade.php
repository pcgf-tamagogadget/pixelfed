  <div class="col-12 col-md-3">
    <ul class="nav flex-column settings-nav">
      <li class="nav-item pl-3 {{request()->is('settings/home')?'active':''}}">
        <a class="nav-link font-weight-light  text-muted" href="{{route('settings')}}">{{ __('admin_panel.settings.sidebar.account') }}</a>
      </li>
      {{-- <li class="nav-item pl-3 {{request()->is('settings/accessibility')?'active':''}}">
        <a class="nav-link font-weight-light text-muted" href="{{route('settings.accessibility')}}">Accessibility</a>
      </li>
      <li class="nav-item pl-3 {{request()->is('settings/email')?'active':''}}">
        <a class="nav-link font-weight-light text-muted" href="{{route('settings.email')}}">Email</a>
      </li> --}}
      @if(config('pixelfed.user_invites.enabled'))
      <li class="nav-item pl-3 {{request()->is('settings/invites*')?'active':''}}">
        <a class="nav-link font-weight-light text-muted" href="{{route('settings.invites')}}">{{ __('admin_panel.settings.sidebar.invites') }}</a>
      </li>
      @endif
      <li class="nav-item pl-3 {{request()->is('settings/notifications')?'active':''}}">
        <a class="nav-link font-weight-light text-muted" href="{{route('settings.notifications')}}">{{ __('admin_panel.settings.sidebar.notifications') }}</a>
      </li>
      {{-- <li class="nav-item pl-3 {{request()->is('settings/password')?'active':''}}">
        <a class="nav-link font-weight-light text-muted" href="{{route('settings.password')}}">Password</a>
      </li> --}}
      <li class="nav-item pl-3 {{request()->is('settings/privacy*')?'active':''}}">
        <a class="nav-link font-weight-light text-muted" href="{{route('settings.privacy')}}">{{ __('admin_panel.settings.sidebar.privacy') }}</a>
      </li>
      {{-- <li class="nav-item pl-3 {{request()->is('settings/relationships*')?'active':''}}">
        <a class="nav-link font-weight-light text-muted" href="{{route('settings.relationships')}}">Relationships</a>
      </li>
      <li class="nav-item pl-3 {{request()->is('settings/reports*')?'active':''}}">
        <a class="nav-link font-weight-light text-muted" href="{{route('settings.reports')}}">Reports</a>
      </li> --}}

      {{-- <li class="nav-item pl-3 {{request()->is('settings/safety*')?'active':''}}">
        <a class="nav-link font-weight-light text-muted" href="{{route('settings.security')}}">Safety</a>
      </li> --}}
      <li class="nav-item pl-3 {{request()->is('settings/security*')?'active':''}}">
        <a class="nav-link font-weight-light text-muted" href="{{route('settings.security')}}">{{ __('admin_panel.settings.sidebar.security') }}</a>
      </li>
      {{-- <li class="nav-item pl-3 {{request()->is('settings/sponsor*')?'active':''}}">
        <a class="nav-link font-weight-light text-muted" href="{{route('settings.sponsor')}}">Sponsor</a>
      </li> --}}
      <li class="nav-item">
        <hr>
      </li>
      {{-- <li class="nav-item pl-3 {{request()->is('*import*')?'active':''}}">
        <a class="nav-link font-weight-light text-muted" href="{{route('settings.import')}}">Import</a>
      </li> --}}
      <li class="nav-item pl-3 {{request()->is('settings/import*')?'active':''}}">
        <a class="nav-link font-weight-light text-muted" href="{{route('settings.import')}}">{{ __('admin_panel.settings.sidebar.import') }}</a>
      </li>
      <li class="nav-item pl-3 {{request()->is('settings/data-export')?'active':''}}">
        <a class="nav-link font-weight-light text-muted" href="{{route('settings.dataexport')}}">{{ __('admin_panel.settings.sidebar.dataExport') }}</a>
      </li>

      @if(config('pixelfed.oauth_enabled') == true)
      {{-- <li class="nav-item pl-3 {{request()->is('settings/applications')?'active':''}}">
        <a class="nav-link font-weight-light text-muted" href="{{route('settings.applications')}}">Applications</a>
      </li> --}}
      <li class="nav-item pl-3 {{request()->is('settings/developers')?'active':''}}">
        <a class="nav-link font-weight-light text-muted" href="{{route('settings.developers')}}">{{ __('admin_panel.settings.sidebar.developers') }}</a>
      </li>
      @endif


      <li class="nav-item pl-3 {{request()->is('settings/labs*')?'active':''}}">
        <a class="nav-link font-weight-light text-muted" href="{{route('settings.labs')}}">{{ __('admin_panel.settings.sidebar.labs') }}</a>
      </li>

      <li class="nav-item pl-3 {{request()->is('settings/arch*')?'active':''}}">
        <a class="nav-link font-weight-light text-muted" href="{{route('settings.labs')}}">{{ __('admin_panel.settings.sidebar.archivedPosts') }}</a>
      </li>
      <li class="nav-item pl-3 {{request()->is('settings/moglod*')?'active':''}}">
        <a class="nav-link font-weight-light text-muted" href="{{route('settings.labs')}}">{{ __('admin_panel.settings.sidebar.moderationLog') }}</a>
      </li>
    </ul>
  </div>
