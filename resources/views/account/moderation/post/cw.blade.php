@extends('layouts.blank')

@section('content')

<div class="container mt-5">
	<div class="row">
		<div class="col-12 col-md-6 offset-md-3 text-center">
			<p class="h1 pb-2" style="font-weight: 200">{{ __('pages.moderation.cw.title') }}</p>
			<p class="lead py-3">{!! __('pages.moderation.cw.body', ['guidelines' => '<a class="font-weight-bold text-dark" href="'.e(route('help.community-guidelines')).'">'.e(__('pages.moderation.communityGuidelines')).'</a>']) !!}</p>
			<p class="font-weight-bold alert alert-danger text-left">{{ __('pages.moderation.continueOrAppeal') }}</p>
		</div>
		<div class="col-12 col-md-6 offset-md-3">
			<hr>
		</div>
		<div class="col-12 col-md-6 offset-md-3 mt-3">
			<p class="h4 font-weight-bold">{{ __('pages.moderation.postDetails') }}</p>
			@if($interstitial->has_media)
			<div class="py-4 align-items-center">
				<div class="d-block text-center text-truncate">
					@if($interstitial->blurhash)
					<canvas id="mblur" width="400" height="400" class="rounded shadow"></canvas>
					@else
					<img src="/storage/no-preview.png" class="mr-3 img-fluid" alt="{{ __('pages.moderation.noPreview') }}">
					@endif
				</div>
				<div class="mt-2 border rounded p-3">
					@if($meta->caption)
					<p class="text-break">
						{{ __('pages.moderation.caption') }} <span class="font-weight-bold">{{$meta->caption}}</span>
					</p>
					@endif
					<p class="mb-0">
						{{ __('pages.moderation.likeCount') }} <span class="font-weight-bold">{{$meta->likes_count}}</span>
					</p>
					<p class="mb-0">
						{{ __('pages.moderation.shareCount') }} <span class="font-weight-bold">{{$meta->reblogs_count}}</span>
					</p>
					<p class="">
						{{ __('pages.moderation.timestamp') }} <span class="font-weight-bold">{{now()->parse($meta->created_at)->format('r')}}</span>
					</p>
					<p class="mb-0" style="word-break: break-all !important;">
						{{ __('pages.moderation.url') }} <span class="font-weight-bold text-primary">{{$meta->url}}</span>
					</p>
				</div>
			</div>
			@else
			<div class="py-4 align-items-center">
				<div class="mt-2 border rounded p-3">
					@if($meta->caption)
					<p class="text-break">
						{{ __('pages.moderation.comment') }} <span class="font-weight-bold">{{$meta->caption}}</span>
					</p>
					@endif
					<p class="mb-0">
						{{ __('pages.moderation.likeCount') }} <span class="font-weight-bold">{{$meta->likes_count}}</span>
					</p>
					<p class="mb-0">
						{{ __('pages.moderation.shareCount') }} <span class="font-weight-bold">{{$meta->reblogs_count}}</span>
					</p>
					<p class="">
						{{ __('pages.moderation.timestamp') }} <span class="font-weight-bold">{{now()->parse($meta->created_at)->format('r')}}</span>
					</p>
					<p class="mb-0" style="word-break: break-all !important;">
						{{ __('pages.moderation.url') }} <span class="font-weight-bold text-primary">{{$meta->url}}</span>
					</p>
				</div>
			</div>
			@endif
		</div>
		<div class="col-12 col-md-6 offset-md-3 my-3">
			<div class="border rounded p-3 border-primary">
				<p class="h4 font-weight-bold pt-2 text-primary">{{ __('pages.moderation.reviewGuidelines') }}</p>
				<p class="lead pt-4 text-primary">{!! __('pages.moderation.safePlace', ['app' => e(config_cache('app.name')), 'guidelines' => '<a class="font-weight-bold text-primary" href="'.e(route('help.community-guidelines')).'">'.e(__('pages.moderation.communityGuidelines')).'</a>']) !!}</p>
			</div>
		</div>

		<div id="appealButton" class="col-12 col-md-6 offset-md-3 mt-3">
			<button type="button" class="btn btn-outline-primary btn-block font-weight-bold" onclick="requestAppeal()">{{ __('pages.moderation.requestAppealButton') }}</button>
		</div>
		<div id="appealForm" class="col-12 col-md-6 offset-md-3 d-none mt-3">
			<form method="post" action="/i/warning">
				@csrf
			<p class="h4 font-weight-bold">{{ __('pages.moderation.requestAppeal') }}</p>
			<p class="pt-4">
				<div class="form-group">
					<textarea class="form-control" rows="4" placeholder="{{ __('pages.moderation.appealPlaceholder') }}" name="appeal_message"></textarea>
				</div>
			</p>
			{{-- <p class="lead"><span class="font-weight-bold">Learn more</span> about what we remove.</p> --}}
			<input type="hidden" name="id" value="{{encrypt($interstitial->id)}}">
				<input type="hidden" name="type" value="{{$interstitial->type}}">
				<input type="hidden" name="action" value="appeal">
				<button type="submit" class="btn btn-outline-primary btn-block font-weight-bold">{{ __('pages.moderation.requestAppealButton') }}</button>
			</form>
		</div>

		<div class="col-12 col-md-6 offset-md-3 mt-4 mb-4">

			<form method="post" action="/i/warning">
				@csrf

				<input type="hidden" name="id" value="{{encrypt($interstitial->id)}}">
				<input type="hidden" name="type" value="{{$interstitial->type}}">
				<input type="hidden" name="action" value="confirm">
				<button type="submit" class="btn btn-primary btn-block font-weight-bold">{{ __('pages.moderation.iUnderstand') }}</button>
			</form>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
	function requestAppeal() {
		$('#appealButton').addClass('d-none');
		$('#appealForm').removeClass('d-none');
	}
</script>
@if($interstitial->blurhash)
<script type="text/javascript">
	const pixels = window.blurhash.decode("{{$interstitial->blurhash}}", 400, 400);
	const canvas = document.getElementById("mblur");
	const ctx = canvas.getContext("2d");
	const imageData = ctx.createImageData(400, 400);
	imageData.data.set(pixels);
	ctx.putImageData(imageData, 0, 0);
</script>
@endif
@endpush
