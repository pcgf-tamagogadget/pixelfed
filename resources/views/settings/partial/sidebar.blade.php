    <div class="col-12 col-md-3">
        <ul class="nav flex-column settings-nav py-3">
            <li class="nav-item pl-3 {{request()->is('settings/home')?'active':''}}">
                <a class="nav-link font-weight-light  text-muted" href="{{route('settings')}}">{{__('settings.sidebarAccount')}}</a>
            </li>
            <li class="nav-item pl-3 {{request()->is('settings/accessibility')?'active':''}}">
                <a class="nav-link font-weight-light text-muted" href="{{route('settings.accessibility')}}">{{__('settings.sidebarAccessibility')}}</a>
            </li>
            <li class="nav-item pl-3 {{request()->is('settings/email')?'active':''}}">
                <a class="nav-link font-weight-light text-muted" href="{{route('settings.email')}}">{{__('settings.sidebarEmail')}}</a>
            </li>
            {{-- @if(config('pixelfed.user_invites.enabled'))
            <li class="nav-item pl-3 {{request()->is('settings/invites*')?'active':''}}">
                <a class="nav-link font-weight-light text-muted" href="{{route('settings.invites')}}">{{__('settings.sidebarInvites')}}</a>
            </li>
            @endif --}}
            <li class="nav-item pl-3 {{request()->is('settings/media*')?'active':''}}">
                <a class="nav-link font-weight-light text-muted" href="{{route('settings.media')}}">{{__('settings.sidebarMedia')}}</a>
            </li>
            {{-- <li class="nav-item pl-3 {{request()->is('settings/notifications')?'active':''}}">
                <a class="nav-link font-weight-light text-muted" href="{{route('settings.notifications')}}">{{__('settings.sidebarNotifications')}}</a>
            </li> --}}
            <li class="nav-item pl-3 {{request()->is('settings/password')?'active':''}}">
                <a class="nav-link font-weight-light text-muted" href="{{route('settings.password')}}">{{__('settings.sidebarPassword')}}</a>
            </li>
            <li class="nav-item pl-3 {{request()->is('settings/privacy*')?'active':''}}">
                <a class="nav-link font-weight-light text-muted" href="{{route('settings.privacy')}}">{{__('settings.sidebarPrivacy')}}</a>
            </li>
            <li class="nav-item pl-3 {{request()->is('settings/relationships*')?'active':''}}">
                <a class="nav-link font-weight-light text-muted" href="{{route('settings.relationships')}}">{{__('settings.sidebarRelationships')}}</a>
            </li>
            <li class="nav-item pl-3 {{request()->is('settings/security*')?'active':''}}">
                <a class="nav-link font-weight-light text-muted" href="{{route('settings.security')}}">{{__('settings.sidebarSecurity')}}</a>
            </li>
            <li class="nav-item pl-3 {{request()->is('settings/timeline*')?'active':''}}">
                <a class="nav-link font-weight-light text-muted" href="{{route('settings.timeline')}}">{{__('settings.sidebarTimelines')}}</a>
            </li>
            <li class="nav-item">
                <hr>
            </li>

            @if((bool) config_cache('pixelfed.oauth_enabled') == true)
            <li class="nav-item pl-3 {{request()->is('settings/applications')?'active':''}}">
                <a class="nav-link font-weight-light text-muted" href="{{route('settings.applications')}}">{{__('settings.sidebarApplications')}}</a>
            </li>
            <li class="nav-item pl-3 {{request()->is('settings/developers')?'active':''}}">
                <a class="nav-link font-weight-light text-muted" href="{{route('settings.developers')}}">{{__('settings.sidebarDevelopers')}}</a>
            </li>
            @endif

            <li class="nav-item pl-3 {{request()->is('*import*')?'active':''}}">
                <a class="nav-link font-weight-light text-muted" href="{{route('settings.import')}}">{{__('settings.sidebarImport')}}</a>
            </li>
            <li class="nav-item pl-3 {{request()->is('settings/data-export')?'active':''}}">
                <a class="nav-link font-weight-light text-muted" href="{{route('settings.dataexport')}}">{{__('settings.sidebarDataExport')}}</a>
            </li>

            <li class="nav-item pl-3 {{request()->is('settings/labs*')?'active':''}}">
                <a class="nav-link font-weight-light text-muted" href="{{route('settings.labs')}}">Labs</a>
            </li>

            @if(config('instance.parental_controls.enabled'))
            <li class="nav-item pl-3 {{request()->is('settings/parental-controls*')?'active':''}}">
                <a class="nav-link font-weight-light text-muted" href="{{route('settings.parental-controls')}}">Parental Controls</a>
            </li>
            @endif
        </ul>
    </div>

    @push('styles')
    <style type="text/css">
        .settings-nav {
            @media only screen and (min-width: 768px) {
                border-right: 1px solid #dee2e6 !important
            }
            height: 100%;
            flex-grow: 1;
        }
    </style>
    @endpush
