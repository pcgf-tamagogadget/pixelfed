@extends('layouts.anon')

@section('content')
<div class="jumbotron jumbotron-fluid bg-primary text-white mb-0 py-4">
	<div class="container">
		<p class="h1 font-weight-light">{{ __('site.aboutCustom.about') }}</p>
		<p class="h3 font-weight-light py-4">{{$page->title ?? __('site.pixelfed_is_an_image_sharing_platform_etc')}}</p>
	</div>
</div>
<div class="bg-white">
	<div class="container d-flex justify-content-center">
		<div class="card mr-3" style="width:800px;margin-top:-30px;">
			<div class="card-body">
				{!! $page->content !!}
			</div>
		</div>
		<div style="width:300px;margin-top:-30px;text-align: center;">
			<div class="card border-left-blue mb-3">
				<div class="card-body">
					<p class="h2 mb-0">{{$stats['posts']}}</p>
					<p class="font-weight-bold mb-0">{{ __('site.aboutCustom.posts') }}</p>
				</div>
			</div>

			<div class="card border-left-blue mb-3">
				<div class="card-body">
					<p class="h2 mb-0">{{$stats['users']}}</p>
					<p class="font-weight-bold mb-0">{{ __('site.aboutCustom.users') }}</p>
				</div>
			</div>

			@if($stats['admin'])
			<div class="card border-left-blue mb-3">
				<div class="card-body">
					<p class="h2 mb-0">
						<a href="{{$stats['admin']->url()}}">
							&commat;{{$stats['admin']->username}}
						</a>
					</p>
					<p class="font-weight-bold mb-0">{{ __('site.aboutCustom.instanceAdmin') }}</p>
				</div>
			</div>
			@endif
		</div>
	</div>
	<div class="container py-5">
	</div>
</div>
<div class="bg-primary pt-5 pb-4">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-4 mb-4">
				<div class="card bg-transparent" style="box-shadow: none;border:1px solid #fff">
					<div class="card-body text-white text-center">
						<p class="font-weight-bold lead mb-0">
							{{ __('site.aboutCustom.adFree') }}
						</p>
						<p class="font-weight-light mb-0">{{ __('site.aboutCustom.adFreeDesc') }}</p>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-4 mb-4">
				<div class="card bg-transparent" style="box-shadow: none;border:1px solid #fff">
					<div class="card-body text-white text-center">
						<p class="font-weight-bold lead mb-0">
							{{ __('site.aboutCustom.chronological') }}
						</p>
						<p class="font-weight-light mb-0">{{ __('site.aboutCustom.chronologicalDesc') }}</p>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-4 mb-4">
				<div class="card bg-transparent" style="box-shadow: none;border:1px solid #fff">
					<div class="card-body text-white text-center">
						<p class="font-weight-bold lead mb-0">
							{{ __('site.aboutCustom.federated') }}
						</p>
						<p class="font-weight-light mb-0">{{ __('site.aboutCustom.federatedDesc') }}</p>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-4 mb-4">
				<div class="card bg-transparent" style="box-shadow: none;border:1px solid #fff">
					<div class="card-body text-white text-center">
						<p class="font-weight-bold lead mb-0">
							{{ __('site.discover') }}
						</p>
						<p class="font-weight-light mb-0">{{ __('site.aboutCustom.discoverDesc') }}</p>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-4 mb-4">
				<div class="card bg-transparent" style="box-shadow: none;border:1px solid #fff">
					<div class="card-body text-white text-center">
						<p class="font-weight-bold lead mb-0">
							{{ __('site.photo_filters') }}
						</p>
						<p class="font-weight-light mb-0">{{ __('site.aboutCustom.photoFiltersDesc') }}</p>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-4 mb-4">
				<div class="card bg-transparent" style="box-shadow: none;border:1px solid #fff">
					<div class="card-body text-white text-center">
						<p class="font-weight-bold lead mb-0">
							{{ __('site.stories') }}
						</p>
						<p class="font-weight-light mb-0">{{ __('site.aboutCustom.comingSoon') }}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('meta')
<meta property="og:description" content="{{ __('site.pixelfed_is_an_image_sharing_platform_etc') }}">
@endpush