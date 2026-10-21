@php
$id = Str::random(14);
@endphp
<h1 class="text-center">{{ __('auth.curated.step1.title') }}</h1>
@if(config_cache('app.rules') && strlen(config_cache('app.rules')) > 5)
<p class="lead text-center">{{ __('auth.curated.step1.rulesLead') }}</p>

@include('auth.curated-register.partials.server-rules')
@else
<p class="lead text-center mt-4">{!! __('auth.curated.step1.noRules', ['terms' => '<a href="/site/terms" target="_blank" class="text-white font-weight-bold">'.e(__('auth.curated.termsOfUse')).'</a>', 'privacy' => '<a href="/site/privacy" target="_blank" class="text-white font-weight-bold">'.e(__('auth.curated.privacyPolicy')).'</a>']) !!}</p>
@endif

<div class="action-btns">
    <form method="post" id="{{$id}}" class="flex-grow-1">
        @csrf
        <input type="hidden" name="step" value="1">
        <input type="hidden" name="age_verified" id="{{$id}}-age-verified" value="">
        <button type="button" class="btn btn-primary rounded-pill font-weight-bold btn-block flex-grow-1" onclick="onSubmit()">{{ __('auth.curated.step1.accept') }}</button>
    </form>

    <a class="btn btn-outline-muted rounded-pill" href="/">{{ __('auth.curated.step1.goBack') }}</a>
</div>

<div class="small-links">
    <a href="/login">{{ __('auth.login') }}</a>
    <span>·</span>
    <a href="/auth/sign_up/resend-confirmation">{{ __('auth.curated.step1.resend') }}</a>
    <span>·</span>
    <a href="{{route('help.curated-onboarding')}}" target="_blank">{{ __('auth.curated.help') }}</a>
</div>

@push('scripts')
<script>
    const minAge = {{ (int) config('pixelfed.min_registration_age', 16) }};

    function onSubmit() {
        // Age verification must always run before advancing past step 1, even
        // when the page re-rendered with step 2 validation errors. The server
        // also enforces the age_verified flag, so this cannot be bypassed by
        // skipping the prompt.
        promptDateOfBirth();
    }

    function submitAgeVerified() {
        document.getElementById('{{$id}}-age-verified').value = '1';
        document.getElementById('{{$id}}').submit();
    }

    function promptDateOfBirth() {
        swal({
            title: @json(__('auth.curated.step1.dobTitle')),
            text: @json(__('auth.curated.step1.dobText')),
            content: {
                element: "input",
                attributes: {
                    placeholder: @json(__('auth.curated.step1.dobPlaceholder')),
                    type: "date",
                    min: '1900-01-01',
                    max: getToday(),
                    pattern: "\d{4}-\d{2}-\d{2}",
                    required: true
                }
            },
            buttons: {
                cancel: false,
                confirm: {
                    text: @json(__('auth.curated.step1.dobConfirm')),
                    className: "swal-button--cancel",
                }
            }
        }).then((inputValue) => {
            if (inputValue === false) return;

            if (inputValue === "") {
                swal(@json(__('auth.curated.step1.oops')), @json(__('auth.curated.step1.dobRequired')), "error");
                return false;
            }

            const dob = new Date(inputValue);
            if (isValidDate(dob)) {
                const age = calculateAge(dob);
                // swal(`Your age is ${age}`);
                if(age >= 120 || age <= 5) {
                    swal({
                        title: @json(__('auth.curated.step1.ineligible')),
                        text: @json(__('auth.curated.step1.invalidDob')),
                        icon: "error",
                        buttons: {
                            cancel: @json(__('auth.curated.step1.understand'))
                        }
                    }).then(() => {
                        window.location.href = '/'
                    });
                    return;
                }
                if (age >= minAge) {
                    submitAgeVerified();
                } else {
                    swal({
                        title: @json(__('auth.curated.step1.ineligible')),
                        text: @json(__('auth.curated.step1.tooYoung', ['age' => (int) config('pixelfed.min_registration_age', 16)])),
                        icon: "error",
                        buttons: {
                            cancel: @json(__('auth.curated.step1.understand'))
                        }
                    }).then(() => {
                        window.location.href = '/'
                    });
                }
            } else {
                swal(@json(__('auth.curated.step1.invalidFormat')));
                return false;
            }
        });
    }

    function calculateAge(dob) {
        const diff_ms = Date.now() - dob.getTime();
        console.log(diff_ms);
        const age_dt = new Date(diff_ms);
        return Math.abs(age_dt.getUTCFullYear() - 1970);
    }

    function getToday() {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1;
        var yyyy = today.getFullYear();

        if (dd < 10) {
           dd = '0' + dd;
        }

        if (mm < 10) {
           mm = '0' + mm;
        }

        yyyy = yyyy - 10;

        return yyyy + '-' + mm + '-' + dd;
    }

    function isValidDate(d) {
        return d instanceof Date && !isNaN(d);
    }
</script>
@endpush
