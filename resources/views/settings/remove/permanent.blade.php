@extends('settings.template')

@section('section')

  <div class="title">
    <h3 class="font-weight-bold">{{ __('settings.remove.delete_your_account') }}</h3>
  </div>
  <hr>
  <div class="mt-3">
  	<p>{!! __('settings.remove.hi_username', ['username' => e(Auth::user()->username)]) !!}</p>

  	<p>{{ __('settings.remove.were_sorry_to_hear_youd_like_to_delete_your_account') }}</p>

  	<p class="pb-1">{!! __('settings.remove.if_youre_just_looking_to_take_a_break_etc', ['url' => e(route('settings.remove.temporary'))]) !!}</p>

    <p class="">{{ __('settings.remove.when_you_press_the_button_below_your_data_will_be_removed_permanently_etc') }}</p>

    <div class="alert alert-danger my-5">
      <span class="font-weight-bold">{{ __('settings.remove.warning') }}</span> {{ __('settings.remove.some_remote_servers_may_contain_your_public_data_etc') }}
    </div>

  	<p>
      <form method="post">
        @csrf
        <div class="custom-control custom-switch mb-3">
          <input type="checkbox" class="custom-control-input" id="confirm-check" name="confirm">
          <label class="custom-control-label font-weight-bold" for="confirm-check">{{ __('settings.remove.i_confirm_that_this_action_is_not_reversible_etc') }}</label>
        </div>
        <button type="submit" class="btn btn-danger font-weight-bold py-0 delete-btn" disabled="">{{ __('settings.remove.permanently_delete_my_account') }}</button>
      </form>
  	</p>
  </div>


@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {
  $('#confirm-check').on('change', function() {
    let el = $(this);
    let state = el.prop('checked');
    if(state == true) {
      $('.delete-btn').removeAttr('disabled');
    } else {
      $('.delete-btn').attr('disabled', '');
    }
  });
});
</script>
@endpush
