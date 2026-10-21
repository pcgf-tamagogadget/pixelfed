@extends('settings.template')

@section('section')

  <div class="title">
    <h3 class="font-weight-bold">{{ __('settings.import.import_from_instagram') }}</h3>
    <p class="lead">{{ __('settings.import.instagram.step', ['number' => 1]) }}</p>
  </div>
  <hr>
  <section>
    <p class="lead">{!! __('settings.import.instagram.backup_required', ['url' => e('https://www.instagram.com/download/request/')]) !!}</p>
  </section>
  <section class="mt-5 col-md-8 offset-md-2">
    <div class="card mb-3 step-one">
      <div class="card-body text-center">
        <p class="h5 font-weight-bold">{!! __('settings.import.instagram.import_photos_directory') !!}</p>
        <p class="text-muted">{{ __('settings.import.instagram.photos_limit') }}</p>
        <hr>
        <form enctype="multipart/form-data" class="" method="post">
          @csrf
          <input type="file" name="media[]" multiple="" directory="" webkitdirectory="" mozdirectory="" accept="image/*">
          <button type="submit" class="mt-4 btn btn-primary btn-block font-weight-bold">{{ __('settings.import.instagram.upload_photos') }}</button>
        </form>
      </div>
    </div>
  </section>

@endsection