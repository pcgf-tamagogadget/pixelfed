@component('mail::message')
# {{ __('emails.adminMessage.title', ['domain' => config('pixelfed.domain.app')]) }}


@component('mail::panel')
{{$msg}}
@endcomponent


<br>

{{ __('emails.common.regards') }}<br>
{{ config('pixelfed.domain.app') }}

@component('mail::subcopy')
{{ __('emails.adminMessage.doNotReply') }}
@endcomponent

@endcomponent

