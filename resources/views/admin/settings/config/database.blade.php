<div class="alert alert-info">{{ __('admin_panel.settings.config.readOnlyDatabase') }}</div>

<div class="form-group row">
  <label for="app_name" class="col-sm-3 col-form-label font-weight-bold text-right">{{ __('admin_panel.settings.config.driver') }}</label>
  <div class="col-sm-9">
    <select class="form-control" disabled>
      <option {{config('database.default') == 'mysql' ? 'selected=""':''}}>MySQL</option>
      <option {{config('database.default') == 'pgsql' ? 'selected=""':''}}>Postgres</option>
      <option {{config('database.default') == 'sqlite' ? 'selected=""':''}}>SQLite</option>
      <option {{config('database.default') == 'sqlsrv' ? 'selected=""':''}}>MSSQL</option>
    </select>
  </div>
</div>
<div class="form-group row">
  <label for="db_host" class="col-sm-3 col-form-label font-weight-bold text-right">{{ __('admin_panel.settings.config.host') }}</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="" name="db_host" disabled value="{{config('database.connections.mysql.host')}}">
  </div>
</div>
<div class="form-group row">
  <label for="db_port" class="col-sm-3 col-form-label font-weight-bold text-right">{{ __('admin_panel.settings.config.port') }}</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="db_port" name="db_port" disabled value="{{config('database.connections.mysql.port')}}">
  </div>
</div>
<div class="form-group row">
  <label for="db_database" class="col-sm-3 col-form-label font-weight-bold text-right">{{ __('admin_panel.settings.config.database') }}</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="db_database" name="db_database" disabled value="{{config('database.connections.mysql.database')}}">
  </div>
</div>
<div class="form-group row">
  <label for="db_username" class="col-sm-3 col-form-label font-weight-bold text-right">{{ __('admin_panel.settings.config.username') }}</label>
  <div class="col-sm-9">
    <input type="text" class="form-control" id="db_username" name="db_username" disabled value="{{config('database.connections.mysql.username')}}">
  </div>
</div>