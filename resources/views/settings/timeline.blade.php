@extends('settings.template')

@section('section')

	<div class="title">
		<h3 class="font-weight-bold">{{__('settings.timelineSettings')}}</h3>
	</div>
	<hr>
	<form method="post">
		@csrf
		<div class="form-check pb-3 d-none">
			<input class="form-check-input" type="checkbox" name="top" {{$top ? 'checked':''}}>
			<label class="form-check-label font-weight-bold" for="">{{__('settings.showTextOnly')}}</label>
			<p class="text-muted small help-text">{{__('settings.showTextOnlyDiscription')}}</p>
		</div>
		<div class="form-check pb-3 d-none">
			<input class="form-check-input" type="checkbox" name="replies" {{$replies ? 'checked':''}}>
			<label class="form-check-label font-weight-bold" for="">{{__('settings.showReplies')}}</label>
			<p class="text-muted small help-text">{{__('settings.showRepliesDiscription')}}</p>
		</div>

        <div class="form-check pb-3">
            <input class="form-check-input" type="checkbox" name="enable_reblogs" {{$userSettings['enable_reblogs'] ? 'checked':''}}>
            <label class="form-check-label font-weight-bold" for="">Show reblogs</label>
            <p class="text-muted small help-text">See reblogs from accounts you follow in your home feed. (Home timeline only)</p>
        </div>

        <div class="form-check pb-3">
            <input class="form-check-input" type="checkbox" name="photo_reblogs_only" {{$userSettings['photo_reblogs_only'] ? 'checked':''}}>
            <label class="form-check-label font-weight-bold" for="">Photo reblogs only</label>
            <p class="text-muted small help-text">Only see reblogs of photos or photo albums. (Home timeline only)</p>
        </div>

		<div class="form-group row mt-5 pt-5">
			<div class="col-12 text-right">
				<hr>
				<button type="submit" class="btn btn-primary font-weight-bold py-0 px-5">{{__('settings.submit')}}</button>
			</div>
		</div>
	</form>

@endsection