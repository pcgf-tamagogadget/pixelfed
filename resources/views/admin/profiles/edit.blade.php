@extends('admin.partial.template-full')

@section('section')
  <div class="title d-flex justify-content-between align-items-center">
    <span><a href="{{route('admin.profiles')}}" class="btn btn-outline-secondary btn-sm font-weight-bold">{{ __('admin_panel.common.back') }}</a></span>
    <h3 class="font-weight-bold">{{ __('admin_panel.profiles.edit.title') }}</h3>
    <span><a href="#" class="btn btn-outline-primary btn-sm font-weight-bold disabled">{{ __('admin_panel.profiles.edit.enableEditing') }}</a></span>
  </div>
  <hr>

  <div class="row mb-3">
    <div class="col-12 col-md-4">
      <div class="card">
        <div class="card-body text-center">
          <img src="{{$profile->avatarUrl()}}" class="box-shadow rounded-circle" width="128px" height="128px">
        </div>
        {{-- <div class="card-footer bg-white">
          <p class="font-weight-bold mb-0 small">Last updated: {{$profile->avatar->updated_at->diffForHumans()}}</p>
        </div> --}}
      </div>
    </div>
    <div class="col-12 col-md-8">
      <table class="table table-striped table-borderless table-sm">
        <tbody>
          @if($user)
          <tr>
            <th scope="row">{{ __('admin_panel.profiles.edit.userId') }}</th>
            <td>{{$user->id}}</td>
          </tr>
          @endif
          <tr>
            <th scope="row">{{ __('admin_panel.profiles.edit.profileId') }}</th>
            <td>{{$profile->id}}</td>
          </tr>
          <tr>
            <th scope="row">{{ __('admin_panel.profiles.edit.username') }}</th>
            <td>
              {{$profile->username}}
              @if($user && $user->is_admin == true)
                <span class="badge badge-danger ml-3">{{ __('admin_panel.profiles.edit.admin') }}</span>
              @endif
            </td>
          </tr>
          <tr>
            <th scope="row">{{ __('admin_panel.profiles.edit.displayName') }}</th>
            <td>{{$profile->name}}</td>
          </tr>
          <tr>
            <th scope="row">{{ __('admin_panel.profiles.edit.joined') }}</th>
            <td>{{$profile->created_at->format('M j Y')}}</td>
          </tr>
          @if($user)
          <tr>
            <th scope="row">{{ __('admin_panel.profiles.edit.email') }}</th>
            <td>
                {{$user->email}}
              @if($user->email_verified_at)
              <span class="text-success font-weight-bold small pl-2">{{ __('admin_panel.profiles.edit.verified') }}</span>
              @else
              <span class="text-danger font-weight-bold small pl-2">{{ __('admin_panel.profiles.edit.unverified') }}</span>
              @endif
            </td>
          </tr>
          @endif
        </tbody>
      </table>
      {{-- <div class="py-3">
        <p class="font-weight-bold mb-0">
          {{$profile->username}}
        </p>
        <p class="h3 font-weight-bold">
          {{$profile->emailUrl()}}
        </p>
        <p class="font-weight-bold mb-0 text-muted">
          Member Since: {{$profile->created_at->format('M Y')}}
        </p>
      </div> --}}
    </div>
  </div>
  <div class="row mb-3">
  	<div class="col-12 col-md-4 mb-3">
  		<div class="card">
  			<div class="card-body text-center">
  				<p class="h4 mb-0 font-weight-bold">{{$profile->statusCount()}}</p>
  				<p class="text-muted font-weight-bold small mb-0">{{ __('admin_panel.profiles.edit.posts') }}</p>
  			</div>
  		</div>
  	</div>
    <div class="col-12 col-md-4 mb-3">
      <div class="card">
        <div class="card-body text-center">
          <p class="h4 mb-0 font-weight-bold">{{$profile->followingCount()}}</p>
          <p class="text-muted font-weight-bold small mb-0">{{ __('admin_panel.profiles.edit.following') }}</p>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-4 mb-3">
      <div class="card">
        <div class="card-body text-center">
          <p class="h4 mb-0 font-weight-bold">{{$profile->followerCount()}}</p>
          <p class="text-muted font-weight-bold small mb-0">{{ __('admin_panel.profiles.edit.followers') }}</p>
        </div>
      </div>
    </div>
  	<div class="col-12 col-md-3 mb-3">
  		<div class="card">
  			<div class="card-body text-center">
  				<p class="h4 mb-0 font-weight-bold">{{$profile->bookmarks()->count()}}</p>
  				<p class="text-muted font-weight-bold small mb-0">{{ __('admin_panel.profiles.edit.bookmarks') }}</p>
  			</div>
  		</div>
  	</div>
    <div class="col-12 col-md-3 mb-3">
      <div class="card">
        <div class="card-body text-center">
          <p class="h4 mb-0 font-weight-bold">{{$profile->likes()->count()}}</p>
          <p class="text-muted font-weight-bold small mb-0">{{ __('admin_panel.profiles.edit.likes') }}</p>
        </div>
      </div>
    </div>
  	<div class="col-12 col-md-3 mb-3">
  		<div class="card">
  			<div class="card-body text-center">
  				<p class="h4 mb-0 font-weight-bold">{{$profile->reports()->count()}}</p>
  				<p class="text-muted font-weight-bold small mb-0">{{ __('admin_panel.profiles.edit.reportsMade') }}</p>
  			</div>
  		</div>
  	</div>
  	<div class="col-12 col-md-3 mb-3">
  		<div class="card">
  			<div class="card-body text-center">
  				<p class="h4 mb-0 font-weight-bold">{{PrettyNumber::size($profile->media()->sum('size'))}}</p>
  				<p class="text-muted font-weight-bold small mb-0">{{ __('admin_panel.profiles.edit.storageUsed') }}</p>
  			</div>
  		</div>
  	</div>
  </div>

  <hr>
  {{-- <div class="mx-3">
  	  <div class="sub-title h4 font-weight-bold mb-4">
  	  	Account Settings
  	  </div>
	  <form>
	  	<div class="form-group">
	  		<label class="font-weight-bold text-muted">Display Name</label>
	  		<input type="text" class="form-control" value="{{$user->name}}">
	  	</div>
	  	<div class="form-group">
	  		<label class="font-weight-bold text-muted">Username</label>
	  		<input type="text" class="form-control" value="{{$user->username}}">
	  	</div>
	  	<div class="form-group">
	  		<label class="font-weight-bold text-muted">Email address</label>
	  		<input type="email" class="form-control" value="{{$user->email}}" placeholder="Enter email">
	        <p class="help-text small text-muted font-weight-bold">
	          @if($user->email_verified_at)
	          <span class="text-success">Verified</span> for {{$user->email_verified_at->diffForHumans()}}
	          @else
	          <span class="text-danger">Unverified</span> email.
	          @endif
	        </p>
	  	</div>
	  </form>
  </div>
  <hr> --}}
  <div class="mx-3">
      <div class="sub-title h4 font-weight-bold mb-4">
        {{ __('admin_panel.profiles.edit.accountActions') }}
      </div>
      <div class="row">

        <div class="col-12 col-md-4">
          <form method="post" action="/i/admin/users/moderation/update" class="pb-3">
            @csrf
            <input type="hidden" name="profile_id" value="{{$profile->id}}">
            <button class="btn btn-outline-primary py-0 font-weight-bold">{{ __('admin_panel.profiles.edit.enforceCw') }}</button>
            <p class="help-text text-muted font-weight-bold small">{{ __('admin_panel.profiles.edit.enforceCwHelp') }}</p>
          </form>
        </div>
        <div class="col-12 col-md-4">
          <form method="post" action="/i/admin/users/moderation/update" class="pb-3">
            @csrf
            <input type="hidden" name="profile_id" value="{{$profile->id}}">
            <button class="btn btn-outline-primary py-0 font-weight-bold">{{ __('admin_panel.profiles.edit.unlistedPosts') }}</button>
            <p class="help-text text-muted font-weight-bold small">{{ __('admin_panel.profiles.edit.unlistedPostsHelp') }}</p>
          </form>
        </div>
        <div class="col-12 col-md-4">
          <form method="post" action="/i/admin/users/moderation/update" class="pb-3">
            @csrf
            <input type="hidden" name="profile_id" value="{{$profile->id}}">
            <button class="btn btn-outline-primary py-0 font-weight-bold">{{ __('admin_panel.profiles.edit.noAutolinking') }}</button>
            <p class="help-text text-muted font-weight-bold small">{{ __('admin_panel.profiles.edit.noAutolinkingHelp') }}</p>
          </form>
        </div>
        <div class="col-12 col-md-4">
          <form method="post" action="/i/admin/users/moderation/update" class="pb-3">
            @csrf
            <input type="hidden" name="profile_id" value="{{$profile->id}}">
            <button class="btn btn-outline-primary py-0 font-weight-bold">{{ __('admin_panel.profiles.edit.disableAccount') }}</button>
            <p class="help-text text-muted font-weight-bold small">{{ __('admin_panel.profiles.edit.disableAccountHelp') }}</p>
          </form>
        </div>

        <div class="col-12 col-md-4">
          <form method="post" action="/i/admin/users/moderation/update" class="pb-3">
            @csrf
            <input type="hidden" name="profile_id" value="{{$profile->id}}">
            <button class="btn btn-outline-primary py-0 font-weight-bold">{{ __('admin_panel.profiles.edit.suspendAccount') }}</button>
            <p class="help-text text-muted font-weight-bold small">{{ __('admin_panel.profiles.edit.suspendAccountHelp') }}</p>
          </form>
        </div>

        <div class="col-12 col-md-4">
          <form method="post" action="/i/admin/users/moderation/update" class="pb-3">
            @csrf
            <input type="hidden" name="profile_id" value="{{$profile->id}}">
            <button class="btn btn-outline-danger py-0 font-weight-bold">{{ __('admin_panel.profiles.edit.lockDownAccount') }}</button>
            <p class="help-text text-muted font-weight-bold small">{{ __('admin_panel.profiles.edit.lockDownAccountHelp') }}</p>
          </form>
        </div>

        <div class="col-12">
          <form method="post" action="/i/admin/users/moderation/update" class="pb-3">
            @csrf
            <input type="hidden" name="profile_id" value="{{$profile->id}}">
            <button class="btn btn-outline-danger font-weight-bold btn-block">{{ __('admin_panel.profiles.edit.deleteAccount') }}</button>
            <p class="help-text text-muted font-weight-bold small">{{ __('admin_panel.profiles.edit.deleteAccountHelp') }}</p>
          </form>
        </div>
      </div>
  </div>
@endsection