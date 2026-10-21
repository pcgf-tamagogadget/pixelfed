@extends('settings.template')

@section('section')

  <div class="title">
    <h3 class="font-weight-bold">{{ __('settings.import.mastodon.import_from_mastodon') }}</h3>
  </div>
  <hr>
  <section>
    <div class="alert alert-info">
      <p class="mb-0 font-weight-bold">{!! __('settings.import.mastodon.you_can_download_a_mastodon_backup_here', ['url' => e('https://www.instagram.com/download/request/')]) !!}</p>
    </div>
    <p class="lead font-weight-bold mb-1">{{ __('settings.import.requirements') }}</p>
    <ul class="lead mb-4">
      <li>{{ __('settings.import.mastodon.outbox_json_file') }}</li>      
      <li>{{ __('settings.import.mastodon.media_attachments_directory') }}</li>      
    </ul>
    <p class="lead font-weight-bold mb-1">{{ __('settings.import.process') }}</p>
    <ol class="lead mb-4">
      <li>{{ __('settings.import.mastodon.upload_outbox_json_file') }}</li>      
      <li>{{ __('settings.import.mastodon.upload_media_attachments_directory') }}</li>      
      <li>{{ __('settings.import.confirm_each_post') }}</li>      
      <li>{{ __('settings.import.import_data') }}</li>      
    </ol>
    <p>
      <a class="btn btn-primary btn-block font-weight-bold py-1" href="#">{{ __('settings.import.start_import') }}</a>
    </p>
  </section>


@endsection