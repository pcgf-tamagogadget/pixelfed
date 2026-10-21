@component('mail::message')
{!! __('emails.common.helloUserComma', ['username' => '**'.e('@'.$verify->username).'**']) !!}


{{ __('emails.curated.accepted.activated') }}

{{ __('emails.curated.accepted.journey') }}

<x-mail::button :url="url('/login?email=' . $verify->email)" color="success">
<strong>{{ __('emails.curated.accepted.button') }}</strong>
</x-mail::button>

{{ __('emails.curated.accepted.next') }}

<x-mail::panel>
{{ __('emails.curated.accepted.tipProfile') }}

{{ __('emails.curated.accepted.tipSharing') }}

{{ __('emails.curated.accepted.tipEngage') }}

{{ __('emails.curated.accepted.tipExplore') }}
</x-mail::panel>

{{ __('emails.curated.accepted.helpCenter', ['help' => url('site/help'), 'guidelines' => url('site/kb/community-guidelines')]) }}

{{ __('emails.curated.accepted.support', ['url' => url('/site/contact')]) }}

{{ __('emails.curated.accepted.welcome') }}

{{ __('emails.common.warmRegards') }}<br>
<strong>{{ config('pixelfed.domain.app') }}</strong>

<br>
<hr>
<p style="font-size:10pt;">{{ __('emails.common.automated') }}</p>
@endcomponent
