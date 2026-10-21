@extends('layouts.app')

@section('content')
<div class="container">
  <div class="col-12">
    <div class="card shadow-none border mt-5">
      <div class="card-body">
        <div class="row">
          <div class="col-12 p-3 p-md-5">
			  <div class="title">
			    <h3 class="font-weight-bold">{{ __('settings.two_factor.setup_two_factor_authentication') }}</h3>
			  </div>
			  <hr>
			  <div class="alert alert-info font-weight-light mb-3">
			  	{{ __('settings.two_factor.we_only_support_two_factor_authentication_via_totp_etc') }}
			  </div>
			  <section class="step-one pb-5">
			  	<div class="sub-title font-weight-bold h5" data-toggle="collapse" data-target="#step1" aria-expanded="true" aria-controls="step1" data-step="1">
			  		{{ __('settings.two_factor.step_1_install_compatible_2fa_mobile_app') }} <i class="float-right fas fa-chevron-down"></i>
			  	</div>
			  	<hr>
			  	<div class="collapse show" id="step1">
				  	<p>{{ __('settings.two_factor.you_will_need_to_install_a_compatible_mobile_app_etc') }}</p>
				  	<ul>
				  		<li><a href="https://1password.com/downloads/" rel="nooopener nofollow">1Password</a></li>
				  		<li><a href="https://authy.com/download/" rel="nooopener nofollow">Authy</a></li>
				  		<li><a href="https://lastpass.com/auth/" rel="nooopener nofollow">LastPass Authenticator</a></li>
				  		<li>
				  			Google Authenticator
				  			<a class="small" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en_CA" rel="nooopener nofollow">
				  				(android)
				  			</a>
				  			<a class="small" href="https://itunes.apple.com/ca/app/google-authenticator/id388497605?mt=8" rel="nooopener nofollow">
				  				(iOS)
				  			</a>
				  		</li>
				  		<li><a href="https://www.microsoft.com/en-us/account/authenticator" rel="nooopener nofollow">Microsoft Authenticator</a></li>
				  	</ul>
			  	</div>
			  </section>

			  <section class="step-two pb-5">
			  	<div class="sub-title font-weight-bold h5" data-toggle="collapse" data-target="#step2" aria-expanded="false" aria-controls="step2" data-step="2">
			  		{{ __('settings.two_factor.step_2_scan_qr_code_and_confirm') }} <i class="float-right fas fa-chevron-down"></i>
			  	</div>
			  	<hr>
			  	<div class="collapse" id="step2">
				  	<p>{{ __('settings.two_factor.please_scan_the_qr_code_etc') }}</p>
				  	<div class="card">
				  		<div class="card-body text-center">
				  			<div class="pb-3">
				  				<p class="font-weight-bold">{{ __('settings.two_factor.qr_code') }}</p>
				  				{!!$qrcode!!}
				  			</div>
				  			<div>
				  				<p class="font-weight-bold">{{ __('settings.two_factor.otp_secret') }}</p>
				  				<input type="text" class="form-control" value="{{ $user->{'2fa_secret'} }}" disabled>
				  			</div>
				  		</div>
				  		<div class="card-body">
				  			<form id="confirm-code">
					  			<div class="form-group">
					  				<label class="font-weight-bold small">{{ __('settings.two_factor.code') }}</label>
					  				<input type="text" name="code" id="verifyCode" class="form-control" placeholder="{{ __('settings.two_factor.code') }}" autocomplete="off">
					  			</div>
					  			<button type="submit" class="btn btn-primary font-weight-bold">{{ __('settings.submit') }}</button>
				  			</form>
				  		</div>
				  	</div>
			  	</div>
			  </section>

			  <section class="step-three pb-5">
			  	<div class="sub-title font-weight-bold h5" data-toggle="collapse" data-target="#step3" aria-expanded="true" aria-controls="step3" data-step="3">
			  		{{ __('settings.two_factor.step_3_download_backup_codes') }} <i class="float-right fas fa-chevron-down"></i>
			  	</div>
			  	<hr>
			  	<div class="collapse" id="step3">
				  	<p>{{ __('settings.two_factor.please_store_the_following_codes_in_a_safe_place_etc') }}</p>

				  	<code id="backup-codes"></code>
			  	</div>
			  </section>

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
	$('#step3').addClass('d-none');
	window.twoFactor = {};
	window.twoFactor.validated = false;

	$(document).on('click', 'div[data-toggle=collapse]', function(e) {
		let el = $(this);
		let step = el.data('step');

		switch(step) {
			case 1:
				$('#step2').collapse('hide');
				$('#step3').collapse('hide');
			break;
			case 2:
				$('#step1').collapse('hide');
				$('#step3').collapse('hide');
			break;
			case 3:
				if(twoFactor.validated == false) {
					e.preventDefault();
					return;
				} else {
					$('#step3').removeClass('d-none');
					$('#step1').collapse('hide');
					$('#step2').collapse('hide');
				}
			break;
		}
	});

	$(document).on('submit', '#confirm-code', function(e) {
		e.preventDefault();
		let el = $(this);
		let code = $('#verifyCode').val();
		if(code.length < 5) {
			swal(@json(__('settings.oops')), @json(__('settings.two_factor.you_need_to_enter_a_valid_code')), 'error');
			return;
		}
		axios.post(window.location.href, {
			code: code
		}).then((res) => {
			twoFactor.validated = true;
			// Backup codes are returned only after verification; inject them
			// into the DOM now rather than rendering them on page load.
			let codes = (res.data && res.data.backup_codes) ? res.data.backup_codes : [];
			let container = document.getElementById('backup-codes');
			container.innerHTML = '';
			codes.forEach(function(c) {
				let p = document.createElement('p');
				p.className = 'mb-0';
				p.textContent = c;
				container.appendChild(p);
			});
			$('#step3').removeClass('d-none');
			$('#step3').collapse('show');
			$('#step1').collapse('hide');
			$('#step2').collapse('hide');
		}).catch((res) => {
			swal(@json(__('settings.oops')), @json(__('settings.two_factor.that_was_an_invalid_code_please_try_again')), 'error');
			return;
		});
	});
});
</script>
@endpush
