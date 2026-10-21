@component('mail::message')
# {{ __('emails.confirmEmail.title') }}

{!! __('emails.confirmEmail.greeting', ['username' => '**'.e('@'.$verify->user->username).'**']) !!}

{{ __('emails.common.disregard') }}

@component('mail::button', ['url' => $verify->url()])
{{ __('emails.confirmEmail.button') }}
@endcomponent

<p>{{ __('emails.confirmEmail.expires') }}</p>
<br>
<small>
  {{ __('emails.common.copyLink') }}
  <br><br>
  {{ $verify->url() }}
</small>
<br><br>

{{ __('emails.common.thanks') }}<br>
<a href="{{ config('app.url') }}">{{ config('pixelfed.domain.app') }}</a>
@endcomponent
