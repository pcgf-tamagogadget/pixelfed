@component('mail::message')
# {{ __('emails.contactAdmin.title') }}

<br>

@if($contact->response_requested)
**{{ __('emails.contactAdmin.responseRequested') }}**
@endif

<br>

{!! __('emails.contactAdmin.sentMessage', ['user' => '[**'.e($contact->user->username).'**]('.e($contact->user->url()).')']) !!}

@component('mail::panel')
{{ $contact->message }}
@endcomponent


@component('mail::button', ['url' => $contact->adminUrl(), 'color' => 'primary'])
{{ __('emails.contactAdmin.button') }}
@endcomponent

@endcomponent