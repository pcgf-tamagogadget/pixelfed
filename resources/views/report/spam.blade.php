@extends('layouts.app')

@section('content')

<div class="container mt-4 mb-5 pb-5">
  <div class="col-12 col-md-8 offset-md-2">
    <div class="card">
      <div class="card-header lead font-weight-bold">
        {{ __('pages.report.titles.spam') }}
      </div>
      <div class="card-body">
        <div class="p-5 text-center">
          <p class="lead">{{ __('pages.report.selectOption') }}</p>
        </div>
        <div class="row">
          @switch(request()->query('type'))

          @case('comment')
          <div class="col-12 col-md-8 offset-md-2 mb-3">
            <p><a class="btn btn-light btn-block p-4 font-weight-bold" href="{{route('report.spam.comment')}}">
              {{ __('pages.report.options.commentSpam') }}
            </a></p>
          </div>
          @break
          @case('post')
          <div class="col-12 col-md-8 offset-md-2 mb-3">
            <p><a class="btn btn-light btn-block p-4 font-weight-bold" href="{{route('report.spam.post')}}">
              {{ __('pages.report.options.postSpam') }}
            </a></p>
          </div>
          @break
          @case('user')
          <div class="col-12 col-md-8 offset-md-2 mb-3">
            <p><a class="btn btn-light btn-block p-4 font-weight-bold" href="{{route('report.spam.profile')}}">
              {{ __('pages.report.options.profileSpam') }}
            </a></p>
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