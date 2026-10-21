<form method="post">
    @csrf
    <div class="form-group row">
      <label for="app_url" class="col-sm-3 col-form-label font-weight-bold text-right">{{ __('admin_panel.settings.config.registration') }}</label>
      <div class="col-sm-9">
        <div class="form-check pb-2">
          <input class="form-check-input" type="checkbox" id="open_registration" name="open_registration" {{config('pixelfed.open_registration') === true ? 'checked=""' : '' }}>
          <label class="form-check-label font-weight-bold" for="open_registration">
            {{config('pixelfed.open_registration') === true ? __('admin_panel.settings.config.open') : __('admin_panel.settings.config.closed') }}
          </label>
          <p class="text-muted small help-text font-weight-bold">{{ __('admin_panel.settings.config.registrationHelp') }}</p>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label for="app_url" class="col-sm-3 col-form-label font-weight-bold text-right">{{ __('admin_panel.settings.config.emailValidation') }}</label>
      <div class="col-sm-9">
        <div class="form-check pb-2">
          <input class="form-check-input" type="checkbox" id="enforce_email_verification" name="enforce_email_verification" {{config('pixelfed.enforce_email_verification') === true ? 'checked=""' : '' }}>
          <label class="form-check-label font-weight-bold" for="open_registration">
            {{config('pixelfed.enforce_email_verification') == true ? __('admin_panel.common.enabled') : __('admin_panel.common.disabled') }}
          </label>
          <p class="text-muted small help-text font-weight-bold">{{ __('admin_panel.settings.config.emailValidationHelp') }}</p>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label for="app_url" class="col-sm-3 col-form-label font-weight-bold text-right">ActivityPub</label>
      <div class="col-sm-9">
        <div class="form-check pb-2">
          <input class="form-check-input" type="checkbox" id="activitypub_enabled" name="activitypub_enabled" {{config('federation.activitypub.enabled') === true ? 'checked=""' : '' }}>
          <label class="form-check-label font-weight-bold" for="activitypub_enabled">
            {{config('federation.activitypub.enabled') === true ? __('admin_panel.common.enabled') : __('admin_panel.common.disabled') }}
          </label>
          <p class="text-muted small help-text font-weight-bold">{{ __('admin_panel.settings.config.activityPubHelp') }}</p>
        </div>
      </div>
    </div>
    <hr>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label font-weight-bold text-right">{{ __('admin_panel.settings.config.accountSize') }}</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" placeholder="1000000" name="max_account_size" value="{{config('pixelfed.max_account_size')}}">
        <span class="help-text font-weight-bold text-muted small">
          {{ __('admin_panel.settings.config.accountSizeHelp') }}
        </span>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label font-weight-bold text-right">{{ __('admin_panel.settings.config.maxUploadSize') }}</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" placeholder="15000" name="max_photo_size" value="{{config('pixelfed.max_photo_size')}}">
        <span class="help-text font-weight-bold text-muted small">
          {{ __('admin_panel.settings.config.maxUploadSizeHelp') }}
        </span>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label font-weight-bold text-right">{{ __('admin_panel.settings.config.captionLength') }}</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" placeholder="500" name="caption_limit" value="{{config('pixelfed.max_caption_length')}}">
        <span class="help-text font-weight-bold text-muted small">
          {{ __('admin_panel.settings.config.captionLengthHelp') }}
        </span>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label font-weight-bold text-right">{{ __('admin_panel.settings.config.maxAlbumSize') }}</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" placeholder="3" name="album_limit" value="{{config('pixelfed.max_album_length')}}">
        <span class="help-text font-weight-bold text-muted small">
          {{ __('admin_panel.settings.config.maxAlbumSizeHelp') }}
        </span>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-3 col-form-label font-weight-bold text-right">{{ __('admin_panel.settings.config.imageQuality') }}</label>
      <div class="col-sm-9">
        <input type="text" class="form-control" placeholder="80" name="image_quality" value="{{config('pixelfed.image_quality')}}">
        <span class="help-text font-weight-bold text-muted small">
          {{ __('admin_panel.settings.config.imageQualityHelp') }}
        </span>
      </div>
    </div>
    <hr>
    <div class="form-group row mb-0">
      <div class="col-12 text-right">
        <button type="submit" class="btn btn-primary font-weight-bold">{{ __('admin_panel.common.submit') }}</button>
      </div>
    </div>
  </form>
