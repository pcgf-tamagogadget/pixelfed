@component('mail::message')
{!! __('emails.common.helloUserComma', ['username' => '**'.e('@'.$verify->username).'**']) !!}

{{ __('emails.curated.rejected.thanksApplying', ['domain' => config('pixelfed.domain.app')]) }}

{{ __('emails.curated.rejected.decision', ['url' => route('help.curated-onboarding')]) }}

{{ __('emails.curated.rejected.reason', ['url' => route('help.community-guidelines')]) }}

{{ __('emails.curated.rejected.contact', ['url' => route('site.contact')]) }}

<br>

{{ __('emails.common.thanks') }}<br>
<a href="{{ config('app.url') }}">{{ config('pixelfed.domain.app') }}</a>
<br>
<hr>
<p style="font-size:10pt;">{{ __('emails.common.automated') }}</p>
@endcomponent
