@extends('settings.template')

@section('section')

  <div class="title">
    <h3 class="font-weight-bold">{{ __('settings.import.import_from_instagram') }}</h3>
    <p class="lead">{{ __('settings.import.instagram.step', ['number' => 2]) }}</p>
  </div>
  <hr>
  <section class="mt-5 col-md-8 offset-md-2">
    <div class="card mb-3 step-two">
      <div class="card-body text-center">
        <p class="h5 font-weight-bold">{!! __('settings.import.instagram.import_media_json_file') !!}</p>
        <p class="text-muted">{{ __('settings.import.instagram.media_json_limit') }}</p>
        <hr>
        <form enctype="multipart/form-data" class="" method="post">
          @csrf
          <input type="file" name="media">
          <button type="submit" class="mt-4 btn btn-primary btn-block font-weight-bold">{{ __('settings.import.instagram.upload_media_json') }}</button>
        </form>
      </div>
      </div>
    </div>
  </section>

@endsection