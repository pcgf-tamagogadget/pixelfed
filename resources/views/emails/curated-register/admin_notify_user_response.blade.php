@component('mail::message')
# {{ __('emails.curated.adminNotifyResponse.title') }} ({{ '#' . $activity->id}})

{{ __('emails.common.hello') }}

{!! __('emails.curated.adminNotifyResponse.intro', ['email' => '**'.e($activity->application->email).'**']) !!}

<x-mail::panel>
<p style="white-space: pre-wrap;">{!! nl2br(e($activity->message)) !!}</p>
</x-mail::panel>

<x-mail::button :url="$activity->adminReviewUrl()" color="success">
<strong>{{ __('emails.curated.adminNotifyResponse.button') }}</strong>
</x-mail::button>

{{ __('emails.common.thanks') }}<br>
<a href="{{ config('app.url') }}">{{ config('pixelfed.domain.app') }}</a>
<br>
<hr>
<p style="font-size:10pt;">{{ __('emails.common.automated') }}</p>
@endcomponent
