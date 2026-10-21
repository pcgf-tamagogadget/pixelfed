@extends('layouts.app')

@section('content')

<div class="container px-0 mt-0 mt-md-4 mb-md-5 pb-md-5">
  <div class="col-12 px-0 col-md-8 offset-md-2">

    <div class="card">
      <div class="card-header lead font-weight-bold bg-white">
        {{ __('pages.report.title') }}
      </div>
      <div class="card-body">
        <div class="p-3 text-center">
          <p class="lead">{{ __('pages.report.selectOption') }}</p>
        </div>
        <div class="row">
          <div class="col-12 col-md-8 offset-md-2 my-3">
            <p><a class="btn btn-light btn-block p-4 font-weight-bold" href="{{route('report.not-interested', ['type' => request()->query('type'),'id' => request()->query('id')])}}">
              {{ __('pages.report.options.notInterested') }}
            </a></p>
          </div>
          @switch(request()->query('type'))

          @case('comment')
          <div class="col-12 col-md-8 offset-md-2 mb-3">
            <p><a class="btn btn-light btn-block p-4 font-weight-bold" href="{{route('report.spam.comment', ['type' => request()->query('type'),'id' => request()->query('id')])}}">
              {{ __('pages.report.options.commentSpam') }}
            </a></p>
          </div>
          <div class="col-12 col-md-8 offset-md-2 my-3">
            <p>
              <a class="btn btn-light btn-block p-4 font-weight-bold" href="{{route('report.sensitive.comment', ['type' => request()->query('type'),'id' => request()->query('id')])}}">
                {{ __('pages.report.options.commentSensitive') }}
              </a>
            </p>
          </div>
          <div class="col-12 col-md-8 offset-md-2 my-3">
            <p>
              <a class="btn btn-light btn-block p-4 font-weight-bold" href="{{route('report.abusive.comment', ['type' => request()->query('type'),'id' => request()->query('id')])}}">
                {{ __('pages.report.options.commentAbusive') }}
              </a>
            </p>
          </div>
          @break
          @case('post')
          <div class="col-12 col-md-8 offset-md-2 mb-3">
            <p>
              <a class="btn btn-light btn-block p-4 font-weight-bold" href="{{route('report.spam.post', ['type' => request()->query('type'),'id' => request()->query('id')])}}">
                {{ __('pages.report.options.postSpam') }}
              </a>
            </p>
          </div>
          <div class="col-12 col-md-8 offset-md-2 my-3">
            <p>
              <a class="btn btn-light btn-block p-4 font-weight-bold" href="{{route('report.sensitive.post', ['type' => request()->query('type'),'id' => request()->query('id')])}}">
                {{ __('pages.report.options.postSensitive') }}
              </a>
            </p>
          </div>
          <div class="col-12 col-md-8 offset-md-2 my-3">
            <p>
              <a class="btn btn-light btn-block p-4 font-weight-bold" href="{{route('report.abusive.post', ['type' => request()->query('type'),'id' => request()->query('id')])}}">
                {{ __('pages.report.options.postAbusive') }}
              </a>
            </p>
          </div>
          @break
          @case('user')
          <div class="col-12 col-md-8 offset-md-2 mb-3">
            <p>
              <a class="btn btn-light btn-block p-4 font-weight-bold" href="{{route('report.spam.profile', ['type' => request()->query('type'),'id' => request()->query('id')])}}">
                {{ __('pages.report.options.profileSpam') }}
              </a>
            </p>
          </div>
          <div class="col-12 col-md-8 offset-md-2 my-3">
            <p>
              <a class="btn btn-light btn-block p-4 font-weight-bold" href="{{route('report.sensitive.profile', ['type' => request()->query('type'),'id' => request()->query('id')])}}">
                {{ __('pages.report.options.profileSensitive') }}
              </a>
            </p>
          </div>
          <div class="col-12 col-md-8 offset-md-2 my-3">
            <p>
              <a class="btn btn-light btn-block p-4 font-weight-bold" href="{{route('report.abusive.profile', ['type' => request()->query('type'),'id' => request()->query('id')])}}">
                {{ __('pages.report.options.profileAbusive') }}
              </a>
            </p>
          </div>
          @break
          @endswitch
          <div class="col-12 col-md-8 offset-md-2 my-3">
            <p>{!! __('pages.report.learnMorePolicy', ['link' => '<a class="font-weight-bold" href="#">'.e(__('pages.report.learnMore')).'</a>']) !!}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
