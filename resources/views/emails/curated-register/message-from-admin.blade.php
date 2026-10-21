@component('mail::message')
# {{ __('emails.curated.messageFromAdmin.title', ['domain' => config('pixelfed.domain.app')]) }}

{{ __('emails.common.hello') }}

{!! __('emails.curated.messageFromAdmin.intro', ['username' => '&commat;**'.e($verify->username).'**']) !!}

{{ __('emails.curated.messageFromAdmin.hasMessage') }}

<x-mail::panel>
<p style="white-space: pre-wrap;">{{ $verify->message }}</p>
</x-mail::panel>

{{ __('emails.curated.messageFromAdmin.doNotRespond') }}

{{ __('emails.common.thanks') }}<br>
<a href="{{ config('app.url') }}">{{ config('pixelfed.domain.app') }}</a>
<br>
<hr>
<p style="font-size:10pt;">{{ __('emails.curated.messageFromAdmin.automated') }}</p>
@endcomponent
