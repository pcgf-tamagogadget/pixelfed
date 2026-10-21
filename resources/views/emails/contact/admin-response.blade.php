<x-mail::message>
{!! __('emails.common.helloUserComma', ['username' => '**&commat;'.e($contact->user->username).'**']) !!}

{{ __('emails.contactResponse.intro', ['domain' => config('pixelfed.domain.app')]) }}

<x-mail::panel>
<i>{{Str::limit($contact->message, 80)}}</i>
</x-mail::panel>

<x-mail::button :url="$url" color="primary">
    {{ __('emails.contactResponse.button') }}
</x-mail::button>

<small>
{!! __('emails.contactResponse.copyUrl', ['url' => '<a href="'.e($url).'">'.e($url).'</a>']) !!}
</small>
<br>
<br>
<br>
<small>
{{ __('emails.common.thanks') }}<br>
{{ __('emails.contactResponse.signature', ['domain' => ucfirst(config('pixelfed.domain.app'))]) }}
</small>
</x-mail::message>
