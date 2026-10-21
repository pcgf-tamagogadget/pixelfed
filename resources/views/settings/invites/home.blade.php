@extends('settings.template')

@section('section')

  <div class="title">
    <h3 class="font-weight-bold">{{ __('settings.invites') }}</h3>
    <p class="lead">{{ __('settings.invites.send_email_invites_to_your_friends_and_family') }}</p>
  </div>
  <hr>
  @if($invites->count() > 0) 
  <table class="table table-light">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">{{ __('settings.email') }}</th>
        <th scope="col">{{ __('settings.invites.valid_for') }}</th>
        <th scope="col">{{ __('settings.invites.actions') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach($invites as $invite)
      <tr>
        <th scope="row">{{$invite->id}}</th>
        <td>{{$invite->email}}</td>
        <td>{{$invite->message}}</td>
        <td>
          @if($invite->used_at == null)
          <button class="btn btn-outline-danger btn-sm">{{ __('settings.security.delete') }}</button>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @else
  <div class="d-flex align-items-center justify-content-center text-center pb-4">
  	<div>
      <p class="pt-5"><i class="far fa-envelope-open text-lighter fa-6x"></i></p>
      <p class="lead">{{ __('settings.invites.you_havent_invited_anyone_yet') }}</p>
      <p><a class="btn btn-primary btn-lg py-0 font-weight-bold" href="{{route('settings.invites.create')}}">{{ __('settings.invites.invite_someone') }}</a></p>
	  	<p class="font-weight-lighter text-muted">{!! __('settings.invites.you_have_invites_left', ['count' => e($limit - $used)]) !!}</p>
  	</div>
  </div>
  @endif
@endsection