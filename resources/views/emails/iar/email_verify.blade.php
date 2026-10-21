@component('mail::message')
<div class="otcontainer">

## {{ __('emails.iar.title') }}
        
<p class="ottext">
    {{ __('emails.common.hello') }}
</p>

<p class="ottext">
    {{ __('emails.iar.thanks', ['domain' => config('pixelfed.domain.app')]) }}
</p>

<p class="ottext">
    {{ __('emails.iar.enterCode') }}
</p>

<div class="otcode">
    {{ $code }}
</div>

<p class="ottext">
{{ __('emails.iar.expires') }}
</p>

<div class="otfooter">
<p>{!! __('emails.iar.trouble', ['link' => '<a href="'.e(route('site.help')).'">'.e(__('emails.iar.supportTeam')).'</a>']) !!}</p>
</div>

</div>
@endcomponent
