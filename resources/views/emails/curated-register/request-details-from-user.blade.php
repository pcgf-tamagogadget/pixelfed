@component('mail::message')
# {{ __('emails.curated.details.title') }}

{!! __('emails.common.helloUser', ['username' => '**'.e('@'.$verify->username).'**']) !!}

{{ __('emails.curated.details.intro') }}

{{ __('emails.curated.details.requested') }}

@component('mail::panel')
<p style="white-space: pre-wrap;">{!! nl2br(e($activity->message)) !!}</p>
@endcomponent
<x-mail::button :url="$activity->emailReplyUrl()" color="success">
<strong>{{ __('emails.curated.details.button') }}</strong>
</x-mail::button>

<p style="font-size:10pt;">{{ __('emails.curated.details.respondPromptly') }}</p>
<br>

{{ __('emails.common.thanks') }}<br>
<a href="{{ config('app.url') }}">{{ config('pixelfed.domain.app') }}</a>
@endcomponent
