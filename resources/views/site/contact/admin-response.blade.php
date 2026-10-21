@extends('layouts.blank')

@section('content')
<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card shadow-none border">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a class="btn btn-link font-weight-bold" href="/i/web">{{ __('site.contactResponse.backToPixelfed') }}</a>
                    <h1 class="h4 mb-0">{{ __('site.contactResponse.title') }}</h1>
                    <p class="d-none d-md-block mb-0 text-muted">{{ __('site.contactResponse.ticketId', ['id' => $contact->id]) }}</p>
                </div>

                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="media">
                            <img src="{{$contact->user->profile->avatarUrl()}}" class="mr-3 rounded-circle" width="40px" height="40px" onerror="this.onerror=null;this.src='/storage/avatars/default.png?v=2'">
                            <div class="media-body">
                                <h5 class="my-0">&commat;{{$contact->user->username}}</h5>
                                <span class="text-muted">{{$contact->user->name}}</span>
                            </div>
                        </div>
                        <p class="my-2 font-weight-bold">{{ __('site.contactResponse.youSent') }}</p>
                        <div class="card shadow-none border bg-light rounded mb-2">
                            <div class="card-body">
                                {{ $contact->message }}
                            </div>
                        </div>
                        <p class="small text-muted">{{ __('site.contactResponse.sentOn', ['date' => $contact->created_at->format('M d, Y'), 'time' => $contact->created_at->format('h:i:s a e')]) }}</p>
                    </div>

                    @if($contact->response)
                    <div class="list-group-item">
                        <p class="my-2 font-weight-bold">{{ __('site.contactResponse.adminResponded') }}</p>
                        <div class="card shadow-none border bg-light rounded mb-2">
                            <div class="card-body">
                                {{ $contact->response }}
                            </div>
                        </div>
                        @if($contact->responded_at)
                        <p class="small text-muted">{{ __('site.contactResponse.respondedOn', ['date' => $contact->responded_at->format('M d, Y'), 'time' => $contact->responded_at->format('h:i:s a e')]) }}</p>
                        @endif
                    </div>
                    <div class="list-group-item">
                        <div class="text-center">
                            <p class="mb-0 small text-muted font-weight-bold">{!! __('site.contactResponse.respondHint') !!}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
