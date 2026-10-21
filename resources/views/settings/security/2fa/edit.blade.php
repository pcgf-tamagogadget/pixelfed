@extends('layouts.app')

@section('content')
<div class="container">
  <div class="col-12">
    <div class="card shadow-none border mt-5">
      <div class="card-body">
        <div class="row">
          <div class="col-12 p-3 p-md-5">
			  <div class="title">
			    <h3 class="font-weight-bold">{{ __('settings.two_factor.edit_two_factor_authentication') }}</h3>
			  </div>

			  <hr>

			  <p class="lead pb-3">
			  	{{ __('settings.two_factor.to_register_a_new_device_you_have_to_remove_etc') }}
			  </p>

			  <div class="card">
			  	<div class="card-header bg-light font-weight-bold">
			  		{{ __('settings.two_factor.authenticator_app') }}
			  	</div>
			  	<div class="card-body d-flex justify-content-between align-items-center">
			  		<i class="fas fa-lock fa-3x text-success"></i>
			  		<p class="font-weight-bold mb-0">
			  			{{ __('settings.two_factor.added_time', ['time' => $user->{'2fa_setup_at'}->diffForHumans()]) }}
			  		</p>
			  	</div>
			  	<div class="card-footer bg-white text-right">
			  		<a class="btn btn-outline-secondary btn-sm px-4 font-weight-bold mr-3" href="{{route('settings.security.2fa.recovery')}}">{{ __('settings.two_factor.view_recovery_codes') }}</a>
			  		<a class="btn btn-outline-danger btn-sm px-4 font-weight-bold remove-device" href="#">{{ __('settings.two_factor.remove') }}</a>
			  	</div>
			  </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {

	$(document).on('click', '.remove-device', function(e) {
		e.preventDefault();
		swal({
			title: @json(__('settings.two_factor.confirm_device_removal')),
			text: @json(__('settings.two_factor.are_you_sure_you_want_to_remove_this_device_etc')),
			icon: 'warning',
			button: {
				text: @json(__('settings.two_factor.confirm_removal')),
				className: 'btn-danger'
			}
		})
		.then((value) => {
			if(value == true) {
				swal({
					title: @json(__('settings.two_factor.confirm_your_2fa_code')),
					text: @json(__('settings.two_factor.enter_a_current_2fa_code_or_a_backup_code_etc')),
					content: 'input',
					icon: 'warning',
					buttons: {
						cancel: true,
						confirm: {
							text: @json(__('settings.two_factor.confirm_removal')),
							className: 'btn-danger'
						}
					}
				})
				.then((code) => {
					if(code) {
						axios.post('/settings/security/2fa/edit', {
							action: 'remove',
							code: code
						})
						.then(function(res) {
							window.location.href = '/settings/security';
						})
						.catch(function(err) {
							let msg = @json(__('settings.two_factor.something_went_wrong_please_try_again'));
							if(err.response && err.response.status === 403) {
								msg = @json(__('settings.two_factor.invalid_2fa_code_please_try_again'));
							}
							swal(@json(__('settings.oops')), msg, 'error');
						})
					}
				});
			}
		});
	});
});

</script>
@endpush
