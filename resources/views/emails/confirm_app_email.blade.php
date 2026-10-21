<x-mail::message>
# {{ __('emails.confirmAppEmail.title') }}

{!! __('emails.common.helloUserComma', ['username' => '**'.e('@'.$verify->user->username).'**']) !!}

{{ __('emails.confirmAppEmail.almostDone') }}

@component('mail::button', ['url' => $appUrl])
{{ __('emails.confirmAppEmail.title') }}
@endcomponent

<p style="color: #d6d3d1;font-size: 10pt">{{ __('emails.confirmAppEmail.mobileOnly') }}</p>
<br>
<p>{{ __('emails.common.disregard') }}</p>

{{ __('emails.common.thanks') }}<br>
<a href="{{ config('app.url') }}">{{ config('pixelfed.domain.app') }}</a>
</x-mail::message>
