@component('mail::message')
# {{ __('emails.emailChange.title') }}


@component('mail::panel')
<p>{{ __('emails.emailChange.body') }}</p>
@endcomponent

<small>{{ __('emails.emailChange.notYou') }}</small>

<br>

{{ __('emails.common.thanks') }}<br>
{{ config('pixelfed.domain.app') }}
@endcomponent
