@extends('settings.template')

@section('section')
<div class="d-flex justify-content-between align-items-center">
    <div class="title d-flex align-items-center" style="gap: 1rem;">
        <p class="mb-0"><a href="/settings/privacy"><i class="far fa-chevron-left fa-lg"></i></a></p>
        <h3 class="font-weight-bold mb-0">{{ __('settings.privacy.featured_collections') }}</h3>
    </div>
</div>
<hr />
@if (session('status'))
<div class="alert alert-success">{{ session('status') }}</div>
@endif
<p class="text-muted small">{{ __('settings.privacy.featured_collections_help') }}</p>
@if($collections->count() > 0)
<div class="list-group">
    @foreach($collections as $collection)
    <div class="list-group-item">
        <div class="d-flex justify-content-between align-items-center">
            <div class="text-truncate pr-3">
                <a href="{{ $collection->collection_url }}" class="text-decoration-none text-dark font-weight-bold" target="_blank" rel="noopener nofollow">
                    {{ $collection->collection_name ?? __('settings.privacy.untitled_collection') }}
                    <i class="far fa-external-link ml-1 text-muted" style="opacity: 0.5"></i>
                </a>
                <div class="small text-muted">
                    @if($collection->actor)
                    {!! __('settings.privacy.featured_by', ['url' => e($collection->actor->url()), 'username' => e($collection->actor->username)]) !!}
                    &middot;
                    @endif
                    {{ __('settings.privacy.added_time', ['time' => $collection->created_at->diffForHumans()]) }}
                </div>
            </div>
            <span class="btn-group">
                <form method="post" onsubmit="return confirm({{ json_encode(__('settings.privacy.remove_yourself_from_this_collection')) }});">
                    @csrf
                    <input type="hidden" name="id" value="{{ $collection->id }}">
                    <button type="submit" class="btn btn-link btn-sm px-3 font-weight-bold text-danger">{{ __('settings.privacy.remove') }}</button>
                </form>
            </span>
        </div>
    </div>
    @endforeach
</div>
<div class="d-flex justify-content-center mt-3 font-weight-bold">
    {{ $collections->links() }}
</div>
@else
<p class="lead text-center font-weight-bold">{{ __('settings.privacy.you_are_not_featured_in_any_collections') }}</p>
@endif

@endsection
