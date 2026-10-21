@extends('layouts.app')

@section('content')

<div class="container px-0 mt-0 mt-md-4 mb-md-5 pb-md-5">
  <div class="col-12 px-0 col-md-8 offset-md-2">
    <div class="card">
      <div class="card-header lead font-weight-bold bg-white">
        {{ __('pages.report.options.notInterested') }}
      </div>
      <div class="card-body">
        <div class="p-5 text-center">
          <p class="lead">{!! __('pages.report.notInterestedBody') !!}</p>
        </div>
{{--         <div class="col-12 col-md-8 offset-md-2">
          <p><a class="font-weight-bold" href="#">
            Learn more
          </a> about our reporting guidelines and policy.</p>
        </div> --}}
      </div>
    </div>
  </div>
</div>

@endsection