@extends('settings.template')

@section('section')

<div class="title">
	<h3 class="font-weight-bold">{{ __('settings.sponsor.title') }}</h3>
	<p class="lead">{{ __('settings.sponsor.add_crowdfunding_links_to_your_profile') }}</p>
</div>
<hr>
<form method="post" action="{{route('settings.sponsor')}}">
	@csrf

	<div class="form-group row">
		<label for="patreon" class="col-sm-3 col-form-label font-weight-bold text-right">Patreon</label>
		<div class="col-sm-9">
			<input type="text" class="form-control" id="patreon" name="patreon" placeholder="patreon.com/dansup" value="{{$sponsors['patreon']}}">
			<p class="help-text small text-muted font-weight-bold">
				{{ __('settings.sponsor.example', ['example' => 'patreon.com/dansup']) }}
			</p>
		</div>
	</div>
	<div class="form-group row">
		<label for="liberapay" class="col-sm-3 col-form-label font-weight-bold text-right">Liberapay</label>
		<div class="col-sm-9">
			<input type="text" class="form-control" id="liberapay" name="liberapay" placeholder="liberapay.com/pixelfed" value="{{$sponsors['liberapay']}}">
			<p class="help-text small text-muted font-weight-bold">
				{{ __('settings.sponsor.example', ['example' => 'liberapay.com/pixelfed']) }}
			</p>
		</div>
	</div>
	<div class="form-group row">
		<label for="opencollective" class="col-sm-3 col-form-label font-weight-bold text-right">OpenCollective</label>
		<div class="col-sm-9">
			<input type="text" class="form-control" id="opencollective" name="opencollective" placeholder="opencollective.com/pixelfed" value="{{$sponsors['opencollective']}}">
			<p class="help-text small text-muted font-weight-bold">
				{{ __('settings.sponsor.example', ['example' => 'opencollective.com/pixelfed']) }}
			</p>
		</div>
	</div>
	<hr>
	<div class="form-group row">
		<div class="col-12 text-right">
			<button type="submit" class="btn btn-primary font-weight-bold float-right">{{ __('settings.submit') }}</button>
		</div>
	</div>
</form>

@endsection