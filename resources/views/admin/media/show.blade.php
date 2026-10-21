@extends('admin.partial.template-full')

@section('section')
<div class="title">
	<h3 class="font-weight-bold d-inline-block">{{ __('admin_panel.media.show.title') }}</h3>
	<p class="font-weight-lighter mb-0">{{ __('admin_panel.common.id') }}: {{$media->id}}</p>
</div>
<hr>
<div class="row">
	<div class="col-12 col-md-8 offset-md-2">
		<div class="card shadow-none border">
			<img class="card-img-top" src="{{$media->thumb()}}">
			<ul class="list-group list-group-flush">
				<li class="list-group-item d-flex justify-content-between">
					<div>
						<p class="mb-0 small">{{ __('admin_panel.media.show.statusId') }}: <a href="{{$media->status->url()}}" class="font-weight-bold">{{$media->status_id}}</a></p>
						<p class="mb-0 small">{{ __('admin_panel.media.show.username') }}: <a href="{{$media->profile->url()}}" class="font-weight-bold">{{$media->profile->username}}</a></p>
						<p class="mb-0 small">{{ __('admin_panel.media.show.size') }}: <span class="filesize font-weight-bold" data-size="{{$media->size}}">0</span></p>
					</div>
					<div>
						<p class="mb-0 small">{{ __('admin_panel.media.show.mime') }}: <span class="font-weight-bold">{{$media->mime}}</span></p>
						<p class="mb-0 small">{{ __('admin_panel.media.show.contentWarning') }}:  <i class="fas {{$media->is_nsfw  ? 'fa-check text-danger':'fa-times text-success'}}"></i></p>
						<p class="mb-0 small">
							{{ __('admin_panel.media.show.remoteMedia') }}: <i class="fas {{$media->remote_media ? 'fa-check text-danger':'fa-times text-success'}}"></i></p>
					</div>
				</li>
			</ul>
		</div>
		<p class="mt-3 small text-muted">
			{{ __('admin_panel.media.show.sha256Hash') }}: <span class="text-monospace text-dark">{{$media->original_sha256}}</span>
		</p>
	</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
	$(document).ready(function() {
		$('.filesize').each(function(k,v) {
			$(this).text(filesize(v.getAttribute('data-size')))
		});
	});
</script>
@endpush