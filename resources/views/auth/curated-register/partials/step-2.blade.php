<h2>{!! __('auth.curated.step2.title', ['domain' => '<strong style="opacity: 1">'.e(config('pixelfed.domain.app')).'</strong>']) !!}</h2>
<form method="post">
    @csrf
    <input type="hidden" name="step" value="2">
    <div class="my-5 details-form">
        <div class="details-form-field">
            <label class="text-muted small font-weight-bold mb-0">{{ __('auth.username') }}</label>
            <div class="input-group">
                <input
                    type="text"
                    class="form-control form-control-lg bg-dark border-dark text-white"
                    placeholder="{{ __('auth.curated.step2.usernamePlaceholder') }}"
                    aria-label="{{ __('auth.curated.step2.yourUsername') }}"
                    aria-describedby="username-addon"
                    maxlength="30"
                    required
                    name="username"
                    value="{{ request()->session()->get('cur-reg.form-username') }}">
                <div class="input-group-append">
                    <span class="input-group-text bg-dark border-dark text-muted font-weight-bold" id="username-addon">&commat;{{ config('pixelfed.domain.app') }}</span>
                </div>
            </div>
            <p class="help-text small text-muted mb-0">{{ __('auth.curated.step2.usernameHelp') }}</p>
        </div>

        <div class="details-form-field">
            <label class="text-muted small font-weight-bold mb-0">{{ __('auth.email') }}</label>
            <input
                type="text"
                class="form-control form-control-lg bg-dark border-dark text-white"
                placeholder="{{ __('auth.curated.yourEmail') }}"
                name="email"
                value="{{ request()->session()->get('cur-reg.form-email') }}"
                required>
        </div>

        <div class="details-form-field">
            <label class="text-muted small font-weight-bold mb-0">{{ __('auth.password') }}</label>
            <input
                type="password"
                autocomplete="new-password"
                minlength="6"
                class="form-control form-control-lg bg-dark border-dark text-white"
                placeholder="{{ __('auth.password') }}"
                name="password"
                required>
        </div>

        <div class="details-form-field">
            <label class="text-muted small font-weight-bold mb-0">{{ __('auth.curated.step2.passwordConfirm') }}</label>
            <input
                type="password"
                autocomplete="new-password"
                minlength="6"
                class="form-control form-control-lg bg-dark border-dark text-white"
                placeholder="{{ __('auth.confirm-password') }}"
                name="password_confirmation"
                required>
        </div>
        <div class="border-top border-dark mt-3 pt-4">
            <p class="lead">
                {{ __('auth.curated.step2.reviewLead', ['domain' => config('pixelfed.domain.app')]) }}
            </p>
        </div>
        <div class="details-form-field">
            <label class="text-muted small font-weight-bold mb-0">{{ __('auth.curated.step2.reasonLabel') }}</label>
            <textarea
                class="form-control form-control-lg bg-dark text-white border-dark"
                rows="4"
                name="reason"
                maxlength="1000"
                id="reason"
                placeholder="{{ __('auth.curated.step2.reasonPlaceholder') }}"
                required>{{ request()->session()->get('cur-reg.form-reason') }}</textarea>
            <div class="help-text small text-muted float-right mt-1 font-weight-bold">
                <span id="charCount" class="text-white">0</span>/<span>1000</span>
            </div>
        </div>
        <div class="border-top border-dark mt-3 pt-4">
            <div class="details-form-field">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="agree" name="agree" required>
                    <label class="custom-control-label text-muted" for="agree">{!! __('auth.curated.step2.agree', ['terms' => '<a href="/site/terms" target="_blank" class="text-white">'.e(__('auth.curated.termsOfUse')).'</a>', 'privacy' => '<a href="/site/privacy" target="_blank" class="text-white">'.e(__('auth.curated.privacyPolicy')).'</a>']) !!}</label>
                </div>
            </div>
        </div>
        <div class="mt-3 pt-4">
            <button class="btn btn-primary rounded-pill font-weight-bold btn-block">{{ __('auth.curated.step2.proceed') }}</button>
        </div>
    </div>
</form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var textInput = document.getElementById('reason');
    var charCount = document.getElementById('charCount');
    var currentLength = textInput.value.length;
    charCount.textContent = currentLength;

    textInput.addEventListener('input', function () {
        var currentLength = textInput.value.length;
        charCount.textContent = currentLength;
    });
});
</script>
@endpush

@push('styles')
<style type="text/css">
.details-form {
    display: flex;
    gap: 1rem;
    flex-direction: column;
}
</style>
@endpush
