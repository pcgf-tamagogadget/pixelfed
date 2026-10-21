@component('mail::message')
# {{ __('emails.curated.confirmEmail.title') }}

{!! __('emails.common.helloUserComma', ['username' => '**'.e('@'.$verify->username).'**']) !!}

{{ __('emails.curated.confirmEmail.intro') }}

<x-mail::button :url="$verify->emailConfirmUrl()" color="success">
<strong>{{ __('emails.curated.confirmEmail.button') }}</strong>
</x-mail::button>


<p style="font-size:10pt;">{{ __('emails.curated.confirmEmail.expires') }}</p>
<br>

{{ __('emails.common.thanks') }}<br>
<a href="{{ config('app.url') }}">{{ config('pixelfed.domain.app') }}</a>
<br>
<hr>
<p style="font-size:10pt;">{{ __('emails.common.automated') }}</p>
@endcomponent
