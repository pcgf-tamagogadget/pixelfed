@component('mail::message')
{{ __('emails.common.hello') }}

{!! __('emails.forgotEmail.intro', ['username' => '[**'.e('@' . $user->username).'**]('.e($user->url()).')', 'domain' => '[**'.e(config('pixelfed.domain.app')).'**]('.e(config('app.url')).')']) !!}

{{ __('emails.forgotEmail.assist') }}

<x-mail::button :url="url('/login?email=' . urlencode($user->email))" color="success">
{!! __('emails.forgotEmail.button', ['username' => '<strong>'.e('@' . $user->username).'</strong>']) !!}
</x-mail::button>

----
<br>

{{ __('emails.forgotEmail.linked') }}
<x-mail::panel>
<p>
<strong>{{$user->email}}</strong>
</p>
</x-mail::panel>

{{ __('emails.forgotEmail.useIt') }}

<small>{{ __('emails.forgotEmail.security', ['reset' => route('password.request'), 'contact' => route('site.contact')]) }}</small>

{{ __('emails.forgotEmail.thankYou') }}

{{ __('emails.common.bestRegards') }}<br>
<a href="{{ config('app.url') }}"><strong>{{ config('pixelfed.domain.app') }}</strong></a>
<br>
<hr>
<p style="font-size:10pt;">{{ __('emails.common.automated') }}</p>
@endcomponent
