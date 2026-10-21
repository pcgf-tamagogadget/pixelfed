<h2><span style="opacity:0.5;">{{ __('auth.curated.step3.title') }}</span></h2>
@if(isset($verifiedEmail))
<div class="alert alert-success bg-success border-success p-4 text-center mt-5">
    <p class="text-center text-white mb-4"><i class="far fa-envelope-open fa-4x"></i></p>
    <p class="lead font-weight-bold text-white mb-0">{{ __('auth.curated.step3.checkInbox') }}</p>
</div>
@else
<p class="lead">{{ __('auth.curated.step3.lead') }}</p>
<form method="post">
    @csrf
    <input type="hidden" name="step" value="3">
    <div class="details-form-field">
          <input
            type="text"
            class="form-control form-control-lg bg-dark border-dark text-white"
            placeholder="{{ __('auth.curated.yourEmail') }}"
            name="email"
            value="{{ request()->session()->get('cur-reg.form-email') }}"
            required>
    </div>
    <x-captcha surface="curated_register" />
    <div class="mt-3 pt-4">
        <button class="btn btn-primary rounded-pill font-weight-bold btn-block">{{ __('auth.curated.step3.correct') }}</button>
    </div>
</form>
@endif
