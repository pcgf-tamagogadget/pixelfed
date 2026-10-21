@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-12 py-5 d-flex justify-content-between align-items-center">
			<p class="h1 mb-0"><i class="far fa-circle"></i> {{ __('pages.account.circles.createTitle') }}</p>
		</div>
		<div class="col-12 col-md-10 offset-md-1">
			<div class="card">
				<div class="card-body px-5">
					@if ($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
					@endif

					<form method="post">
						@csrf
						<div class="form-group row">
							<label class="col-sm-2 col-form-label font-weight-bold text-muted">{{ __('pages.account.circles.name') }}</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" placeholder="{{ __('pages.account.circles.namePlaceholder') }}" name="name" autocomplete="off">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label font-weight-bold text-muted">{{ __('pages.account.circles.description') }}</label>
							<div class="col-sm-10">
								<textarea class="form-control" placeholder="{{ __('pages.account.circles.descriptionPlaceholder') }}" rows="3" name="description"></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label font-weight-bold text-muted">{{ __('pages.account.circles.visibility') }}</label>
							<div class="col-sm-10">
								<select class="form-control" name="scope">
									<option value="public">{{ __('pages.account.circles.scopePublic') }}</option>
									<option value="unlisted">{{ __('pages.account.circles.scopeUnlisted') }}</option>
									<option value="private">{{ __('pages.account.circles.scopePrivate') }}</option>
									<option value="exclusive">{{ __('pages.account.circles.scopeExclusive') }}</option>
								</select>
								<p class="help-text font-weight-bold text-muted small">{{ __('pages.account.circles.visibilityHelp') }}</p>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-2 font-weight-bold text-muted">{{ __('pages.account.circles.bccMode') }}</div>
							<div class="col-sm-10">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" name="bcc">
									<label class="form-check-label"></label>
								</div>
								<p class="help-text mb-0 small text-muted">{{ __('pages.account.circles.bccHelp') }}</p>
							</div>
						</div>
						<hr>
						<div class="form-group row">
							<label class="col-sm-2 col-form-label font-weight-bold text-muted">{{ __('pages.account.circles.members') }}</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" placeholder="">
							</div>
						</div>
						<hr>
						<div class="form-group row">
							<div class="col-sm-10 offset-sm-2">
								<div class="custom-control custom-switch">
									<input type="checkbox" class="custom-control-input" name="active" id="activeSwitch">
									<label class="custom-control-label font-weight-bold text-muted" for="activeSwitch">{{ __('pages.account.circles.active') }}</label>
								</div>
							</div>
						</div>
						<div class="form-group text-right mb-0">
							<button type="submit" class="btn btn-primary btn-sm py-1 font-weight-bold">{{ __('pages.account.circles.create') }}</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
	


</script>
@endpush