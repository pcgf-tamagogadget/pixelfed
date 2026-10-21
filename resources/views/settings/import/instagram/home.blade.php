@extends('settings.template')

@section('section')

  <div class="title">
    <h3 class="font-weight-bold">{{ __('settings.import.import_from_instagram') }}</h3>
  </div>
  <hr>
  <section>
    <div class="alert alert-info">
      <p class="mb-0 font-weight-bold">{!! __('settings.import.instagram.you_can_download_an_instagram_backup_here', ['url' => e('https://www.instagram.com/download/request/')]) !!}</p>
    </div>
    <p class="lead font-weight-bold mb-1">{{ __('settings.import.requirements') }}</p>
    <ul class="lead mb-4">
      <li>{{ __('settings.import.instagram.media_json_file') }}</li>      
      <li>{{ __('settings.import.instagram.photos_directory') }}</li>      
    </ul>
    <p class="lead font-weight-bold mb-1">{{ __('settings.import.process') }}</p>
    <ol class="lead mb-4">
      <li>{{ __('settings.import.instagram.upload_media_json_file') }}</li>      
      <li>{{ __('settings.import.instagram.upload_photos_directory') }}</li>      
      {{-- <li>Confirm each post</li> --}}
      <li>{{ __('settings.import.import_data') }}</li>      
    </ol>
    <form method="post">
      @csrf
      <p>
        <button type="submit" class="btn btn-outline-primary btn-block font-weight-bold py-1">{{ __('settings.import.start_import') }}</button>
      </p>
    </form>
  </section>


@endsection