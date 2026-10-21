<div class="alert alert-info">{{ __('admin_panel.settings.config.readOnlyCache') }}</div>

<div class="form-group row">
  <label for="app_name" class="col-sm-3 col-form-label font-weight-bold text-right">{{ __('admin_panel.settings.config.driver') }}</label>
  <div class="col-sm-9">
    <select class="form-control" disabled>
      <option {{config('cache.default') == 'apc' ? 'selected=""':''}}>APC</option>
      <option {{config('cache.default') == 'array' ? 'selected=""':''}}>{{ __('admin_panel.settings.config.array') }}</option>
      <option {{config('cache.default') == 'database' ? 'selected=""':''}}>{{ __('admin_panel.settings.config.database') }}</option>
      <option {{config('cache.default') == 'file' ? 'selected=""':''}}>{{ __('admin_panel.settings.config.file') }}</option>
      <option {{config('cache.default') == 'memcached' ? 'selected=""':''}}>Memcached</option>
      <option {{config('cache.default') == 'redis' ? 'selected=""':''}}>Redis</option>
    </select>
  </div>
</div>

<div class="form-group row">
  <label for="db_host" class="col-sm-3 col-form-label font-weight-bold text-right">{{ __('admin_panel.settings.config.cachePrefix') }}</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" disabled value="{{config('cache.prefix')}}">
  </div>
</div>