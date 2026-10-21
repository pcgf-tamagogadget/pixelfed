@extends('settings.template')

@section('section')

  <div class="title">
    <h3 class="font-weight-bold">{{__('settings.import.import_from_instagram')}}</h3>
  </div>
  <hr>
  <section>
    <p class="lead">{!! __('settings.import.instagram.backup_required', ['url' => e('https://www.instagram.com/download/request/')]) !!}</p>
  </section>
  <section class="mt-5 col-md-8 offset-md-2">
    <div class="card mb-3 step-one">
      <div class="card-body text-center">
        <p class="h3 font-weight-bold text-uppercase text-muted">{{ __('settings.import.instagram.step', ['number' => 1]) }}</p>
        <p class="h5 font-weight-bold">{!! __('settings.import.instagram.import_photos_directory') !!}</p>
        <p class="text-muted">{!! __('settings.import.instagram.photos_limit_50mb_guide', ['url' => '#']) !!}</p>
        <hr>
        <form enctype="multipart/form-data" class="">
          @csrf
          <input type="file" name="photos[]" multiple="" directory="" webkitdirectory="" mozdirectory="">
          <button type="submit" class="mt-4 btn btn-primary btn-block font-weight-bold">{{ __('settings.import.instagram.upload_photos') }}</button>
        </form>
      </div>
    </div>
    <div class="card mb-3 step-two">
      <div class="card-body text-center">
        <p class="h3 font-weight-bold text-uppercase text-muted">{{ __('settings.import.instagram.step', ['number' => 2]) }}</p>
        <p class="h5 font-weight-bold">{!! __('settings.import.instagram.import_media_json_file') !!}</p>
        <p class="text-muted">{{ __('settings.import.instagram.media_json_limit') }}</p>
        <hr>
        <form enctype="multipart/form-data" class="">
          @csrf
          <input type="file" name="media">
          <button type="submit" class="mt-4 btn btn-primary btn-block font-weight-bold">{{ __('settings.import.instagram.upload_media_json') }}</button>
        </form>
      </div>
      </div>
    <div class="card mb-3 step-three">
      <div class="card-body text-center">
        <p class="h3 font-weight-bold text-uppercase text-muted">{{ __('settings.import.instagram.step', ['number' => 3]) }}</p>
        <p class="h5 font-weight-bold">{{ __('settings.import.instagram.audit_data') }}</p>
        <p class="text-muted">{{ __('settings.import.instagram.manually_approve_each_import_or_bulk_approve') }}</p>
        <hr>
        <form enctype="multipart/form-data" class="">
          @csrf
          <button type="submit" class="mt-4 btn btn-primary btn-block font-weight-bold">{{ __('settings.import.instagram.start_audit') }}</button>
        </form>
      </div>
      </div>
    </div>
  </section>

@endsection

@push('scripts')
<script type="text/javascript">
  $(document).ready(function() {
    var currentStep = 1;
    var stepOne = $('.step-one');
    var stepTwo = $('.step-two');
    var stepThree = $('.step-three');

    if(currentStep == 1) {

      stepTwo.addClass('card-disabled').find('form').hide();
      stepThree.addClass('card-disabled').find('form').hide();

    } else if(currentStep == 2) {

      stepOne.addClass('card-disabled').find('form').hide();
      stepThree.addClass('card-disabled').find('form').hide();

    } else if(currentStep == 3) {

      stepOne.addClass('card-disabled').find('form').hide();
      stepTwo.addClass('card-disabled').find('form').hide();

    }
  });
</script>
@endpush