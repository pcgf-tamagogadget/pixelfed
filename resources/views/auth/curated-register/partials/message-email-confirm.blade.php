<p class="mt-5 lead text-center font-weight-bold">{{ __('auth.curated.pleaseVerifyEmail') }}</p>
<form method="post">
    @csrf
    <input type="hidden" name="action" value="email">
    <div class="form-group">
        <input
            type="email"
            class="form-control form-control-lg bg-dark border-dark text-white"
            name="email"
            placeholder="{{ __('auth.curated.yourEmail') }}"
            required />
    </div>
    <x-captcha surface="curated_register" />
    <div class="d-flex justify-content-center">
        <button class="btn btn-primary font-weight-bold rounded-pill px-5">{{ __('auth.curated.verify') }}</button>
    </div>
</form>
<hr class="border-dark">
<p class="text-muted small text-center">{!! __('auth.curated.helpCenterHint', ['link' => '<a href="'.e(route('help.curated-onboarding')).'" style="font-weight: 600;">'.e(__('auth.curated.curatedOnboarding')).'</a>']) !!}</p>
