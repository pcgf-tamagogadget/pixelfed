@extends('admin.partial.template-full')

@section('section')
</div>
<div class="header bg-primary pb-3 mt-n4">
	<div class="container-fluid">
		<div class="header-body">
			<div class="row align-items-center py-4">
				<div class="col-lg-6 col-7">
					<p class="display-1 text-white d-inline-block mb-0">{{ __('admin_panel.customEmoji.notEnabled.title') }}</p>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container mt-5">
	<div class="row justify-content-center">
		<div class="col-12 col-md-6">
			<h1 class="text-center">{{ __('admin_panel.customEmoji.notEnabled.heading') }}</h1>
			<p class="text-center">{!! __('admin_panel.customEmoji.notEnabled.instructions') !!}</p>
		</div>
	</div>
</div>
@endsection
