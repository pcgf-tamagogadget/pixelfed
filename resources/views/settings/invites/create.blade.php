@extends('settings.template')

@section('section')

  <div class="title">
    <h3 class="font-weight-bold">{{ __('settings.invites.send_invite') }}</h3>
    <p class="lead">{!! __('settings.invites.invite_friends_or_family_to_join_you_on', ['domain' => e(config('pixelfed.domain.app'))]) !!}</p>
  </div>
  <hr>

  @if(config('pixelfed.user_invites.limit.daily') != 0)
  <div class="alert alert-warning">
    <div class="font-weight-bold">{{ __('settings.invites.warning') }}</div>
    <p class="mb-0">{{ __('settings.invites.you_may_only_send_invites_per_day', ['count' => config('pixelfed.user_invites.limit.daily')]) }}</p>
  </div>
  @endif

  <form method="post">
    @csrf
    <div class="form-group">
      <label>{{ __('settings.invites.email_address') }}</label>
      <input type="email" class="form-control" name="email" placeholder="friend@example.org" autocomplete="off">
    </div>
    <div class="form-group">
      <label>{{ __('settings.invites.message') }}</label>
      <textarea class="form-control" name="message" placeholder="{{ __('settings.invites.add_an_optional_message') }}" rows="2"></textarea>
      <p class="help-text mb-0 text-right small text-muted"><span class="message-count">0</span>/<span class="message-limit">500</span></p>
    </div>
    <div class="form-group form-check">
      <input type="checkbox" class="form-check-input" id="tos" name="tos">
      <label class="form-check-label font-weight-bold small" for="tos">{!! __('settings.invites.i_confirm_this_invitation_is_not_in_violation_etc', ['terms' => e(route('site.terms')), 'privacy' => e(route('site.privacy'))]) !!}</label>
    </div>
    <hr>
    <p class="float-right">
      <button type="submit" class="btn btn-primary font-weight-bold py-0 form-submit">{{ __('settings.invites.send_invite') }}</button>
    </p>
  </form>
@endsection

@push('scripts')
<script type="text/javascript">
  
  $('textarea[name="message"]').on('change keyup paste', function(e) {
    let el = $(this);
    let len = el.val().length;
    let limit = $('.message-limit').text();

    if(len > 100) {
      el.attr('rows', '4');
    }

    if(len > limit) {
      let diff = len - limit;
      $('.message-count').addClass('text-danger').text('-'+diff);
      $('.form-submit').attr('disabled','');
    } else {
      $('.message-count').removeClass('text-danger').text(len);
      $('.form-submit').removeAttr('disabled');
    }

  });

</script>
@endpush