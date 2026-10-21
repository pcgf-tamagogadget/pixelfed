@extends('settings.template')

@section('section')
<div class="d-flex justify-content-between align-items-center">
    <div class="title d-flex align-items-center" style="gap: 1rem;">
        <p class="mb-0"><a href="/settings/privacy"><i class="far fa-chevron-left fa-lg"></i></a></p>
        <h3 class="font-weight-bold mb-0">{{ __('settings.privacy.quotes_of_your_posts') }}</h3>
    </div>
</div>
<hr />
@if (session('status'))
<div class="alert alert-success">{{ session('status') }}</div>
@endif
<p class="text-muted small">{{ __('settings.privacy.quotes_help') }}</p>
@if($quotes->count() > 0)
<div class="list-group">
    @foreach($quotes as $quote)
    <div class="list-group-item">
        <div class="d-flex justify-content-between align-items-center">
            <div class="text-truncate pr-3">
                <a href="{{ $quote->quote_url }}" class="text-decoration-none text-dark font-weight-bold" target="_blank" rel="noopener nofollow">
                    @if($quote->actor)
                    {{ __('settings.privacy.quote_by', ['username' => $quote->actor->username]) }}
                    @else
                    {{ __('settings.privacy.quote_post') }}
                    @endif
                    <i class="far fa-external-link ml-1 text-muted" style="opacity: 0.5"></i>
                </a>
                <div class="small text-muted">
                    @if($quote->status)
                    {!! __('settings.privacy.of_your_post', ['url' => e($quote->status->url())]) !!}
                    &middot;
                    @endif
                    {{ __('settings.privacy.approved_time', ['time' => $quote->created_at->diffForHumans()]) }}
                </div>
            </div>
            <span class="btn-group">
                <form method="post" onsubmit="return confirm({{ json_encode(__('settings.privacy.revoke_approval_for_this_quote')) }});">
                    @csrf
                    <input type="hidden" name="id" value="{{ $quote->id }}">
                    <button type="submit" class="btn btn-link btn-sm px-3 font-weight-bold text-danger">{{ __('settings.privacy.revoke') }}</button>
                </form>
            </span>
        </div>
    </div>
    @endforeach
</div>
<div class="d-flex justify-content-center mt-3 font-weight-bold">
    {{ $quotes->links() }}
</div>
@else
<p class="lead text-center font-weight-bold">{{ __('settings.privacy.nobody_has_quoted_your_posts_yet') }}</p>
@endif

@endsection
