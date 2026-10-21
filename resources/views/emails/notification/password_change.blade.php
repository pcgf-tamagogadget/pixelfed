@component('mail::message')
# {{ __('emails.passwordChange.title') }}

{!! __('emails.common.helloUserComma', ['username' => '&commat;'.e($user->username)]) !!}

@component('mail::panel')
<p>{{ __('emails.passwordChange.body') }}</p>
@endcomponent

<small>{{ __('emails.passwordChange.notYou') }}</small>

<br>

{{ __('emails.common.thanks') }}<br>
{{ config('pixelfed.domain.app') }}
@endcomponent
