<x-mail::message>
# {{ __('emails.adminReport.autospamTitle') }} (#{{ $report['id'] }})

{{ __('emails.adminReport.autospamDetected') }}
**{{ __('emails.adminReport.actionRequired') }}** <br />
{{ __('emails.adminReport.pleaseReview') }}

<x-mail::button :url="$url">
{{ __('emails.adminReport.reviewAutospam') }}
</x-mail::button>

@if($reported_status)
<x-mail::panel>
<p style="font-size: 13px; color: #cccccc; text-align: center; font-weight: bold;margin-bottom: 10px;">{{ __('emails.adminReport.reportedStatus') }}</p>
<div style="display: flex; align-items: center;gap: 10px;">
@if(isset($reported_status['content']))
<div style="font-size: 12px !important;">{{ strip_tags(str_replace(["\n", "\r", "\r\n"], ' ', $reported_status['content'])) }}</div>
@endif
</div>
<div style="display: flex; align-items: center; justify-content: space-between;margin-top:10px;">
<a style="font-size: 11px !important;font-weight: bold;text-decoration: none;" href="{{ url('/i/web/post/' . $reported_status['id'])}}">
	{{ __('emails.adminReport.viewStatus') }}
</a>
<p style="font-size: 11px !important;font-weight: bold;">
	{{ __('emails.adminReport.posted', ['time' => now()->parse($reported_status['created_at'])->diffForHumans()]) }}
</p>
</div>
</x-mail::panel>
@endif

@if($reported_account && isset($reported_account['id']))
<x-mail::panel>
<p style="font-size: 13px; color: #cccccc; text-align: center; font-weight: bold;margin-bottom: 10px;">{{ __('emails.adminReport.reportedAccount') }}</p>

<div style="display: flex; align-items: flex-start;gap: 10px;">

<img
	src="{{$reported_account['avatar']}}"
	width="50"
	height="50"
	alt="{{ __('emails.adminReport.avatar') }}"
	style="border-radius: 10px;min-width: 50px;flex-grow: 1;"
	onerror="this.src='{{url('/storage/avatars/default.jpg')}}';this.onerror=null;" />
<div>

<p style="margin-bottom: 0;">
<a href="{{ url('/i/web/profile/' . $reported_account['id']) }}" style="text-decoration: none;font-weight: bold">{{ $reported_account['username'] }}</a>
</p>

<p style="margin-bottom: 5px;font-size: 10px;opacity: 0.5;">
{{ strip_tags(str_replace(["\n", "\r", "\r\n"], ' ', $reported_account['note'])) }}
</p>

<div style="display: flex; align-items: center; gap: 5px;">
<p style=\"font-size: 10px;margin-bottom: 0;\">{{ __('emails.adminReport.postsCount', ['count' => $reported_account['statuses_count']]) }}</p>
<p style="font-size: 10px;margin-bottom: 0;">·</p>
<p style=\"font-size: 10px;margin-bottom: 0;\">{{ __('emails.adminReport.followersCount', ['count' => $reported_account['followers_count']]) }}</p>
<p style="font-size: 10px;margin-bottom: 0;">·</p>
<p style=\"font-size: 10px;margin-bottom: 0;\">{{ __('emails.adminReport.followingCount', ['count' => $reported_account['following_count']]) }}</p>
<p style="font-size: 10px;margin-bottom: 0;">·</p>
<p style="font-size: 10px;margin-bottom: 0;">{{ __('emails.adminReport.joined', ['time' => now()->parse($reported_account['created_at'])->diffForHumans()]) }}</p>
</div>

</div>
</div>
</x-mail::panel>
@endif

<p style="font-size: 12px;color: #cccccc;text-align: center;">
{{ __('emails.adminReport.footer', ['domain' => config('pixelfed.domain.app')]) }}<br />
{{ __('emails.adminReport.footerMistake') }}
</p>
</x-mail::message>
