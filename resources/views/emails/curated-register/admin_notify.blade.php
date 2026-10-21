@component('mail::message')
# [#{{$verify->id}}] {{ __('emails.curated.adminNotify.title') }}

{{ __('emails.curated.adminNotify.helloAdmin') }}

**{{ __('emails.curated.adminNotify.pleaseReview') }}**

<x-mail::panel>
<p>
<small>
{{ __('emails.curated.adminNotify.username') }} <strong>{{ $verify->username }}</strong>
</small>
<br>
<small>
{{ __('emails.curated.adminNotify.email') }} <strong>{{ $verify->email }}</strong>
</small>
</p>

<hr>

<small><strong>*{{ __('emails.curated.adminNotify.reason') }}*</strong></small>
<p style="font-size:9pt;">{!! nl2br(e(Str::limit($verify->reason_to_join, 300))) !!}</p>
</x-mail::panel>

<x-mail::button :url="$verify->adminReviewUrl()" color="success">
<strong>{{ __('emails.curated.adminNotify.button') }}</strong>
</x-mail::button>

{{ __('emails.common.thanks') }}<br>
<a href="{{ config('app.url') }}">{{ config('pixelfed.domain.app') }}</a>
<br>
<hr>
<p style="font-size:10pt;">{{ __('emails.common.automated') }}</p>
@endcomponent
