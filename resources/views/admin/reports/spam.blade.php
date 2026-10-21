@extends('admin.partial.template-full')

@section('section')
</div>
<div class="header bg-primary pb-3 mt-n4">
	<div class="container-fluid">
		<div class="header-body">
			<div class="row align-items-center py-4">
				<div class="col-lg-6 col-7">
					<p class="display-1 text-white d-inline-block mb-0">{{ __('admin_panel.reports.spam.title') }}</p>
					<p class="lead text-white mb-0 mt-n3">{{ __('admin_panel.reports.spam.subtitle') }}</p>
				</div>
			</div>
			<div class="row">
				<div class="col-xl-3 col-md-6">
					<div class="card card-stats">
						<div class="card-body">
							<div class="row">
								<div class="col">
									<h5 class="card-title text-uppercase text-muted mb-0">{{ __('admin_panel.reports.spam.activeReports') }}</h5>
									<span class="h2 font-weight-bold mb-0">{{$openCount}}</span>
								</div>
								<div class="col-auto">
									<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
										<i class="far fa-exclamation-circle"></i>
									</div>
								</div>
							</div>
							<p class="mt-3 mb-0 text-sm">
								<span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{$monthlyCount}}</span>
								<span class="text-nowrap">{{ __('admin_panel.reports.spam.inLast30Days') }}</span>
							</p>
						</div>
					</div>
				</div>

				<div class="col-xl-3 col-md-6">
					<div class="card card-stats">
						<div class="card-body">
							<div class="row">
								<div class="col">
									<h5 class="card-title text-uppercase text-muted mb-0">{{ __('admin_panel.reports.spam.avgResponseTime') }}</h5>
									<span class="h2 font-weight-bold mb-0">{{$avgOpen}}</span>
								</div>
								<div class="col-auto">
									<div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
										<i class="far fa-clock"></i>
									</div>
								</div>
							</div>
							<p class="mt-3 mb-0 text-sm">
								<span class="text-nowrap">{{ __('admin_panel.reports.spam.inLast30Days') }}</span>
							</p>
						</div>
					</div>
				</div>

				@if($uncategorized)
				<div class="col-xl-3 col-md-6">
					<div class="card card-stats">
						<div class="card-body">
							<div class="row">
								<div class="col">
									<h5 class="card-title text-uppercase text-muted mb-0">{{ __('admin_panel.reports.spam.uncategorized') }}</h5>
									<span class="h2 font-weight-bold mb-0">{{ __('admin_panel.reports.spam.reportsFound') }}</span>
								</div>
								<div class="col-auto">
									<div class="icon icon-shape bg-danger text-white rounded-circle shadow">
										<i class="far fa-exclamation-triangle"></i>
									</div>
								</div>
							</div>
							<form action="/i/admin/reports/autospam/sync" method="post" class="mt-2 p-0">
								@csrf
								<button type="submit" class="btn btn-danger py-1 px-2"><i class="far fa-ambulance mr-2"></i> {{ __('admin_panel.reports.spam.manualFix') }}</button>
							</form>
						</div>
					</div>
				</div>
				@endif

				<div class="col-xl-2 col-md-6">
					<div class="mb-3">
						<h5 class="text-light text-uppercase mb-0">{{ __('admin_panel.reports.spam.totalReports') }}</h5>
						<span class="text-white h2 font-weight-bold mb-0">{{$totalCount}}</span>
					</div>
					<div class="">
						<h5 class="text-light text-uppercase mb-0">{{ __('admin_panel.reports.spam.reportsPerUser') }}</h5>
						<span class="text-white h2 font-weight-bold mb-0">{{$avgCount}}</span>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<div class="container-fluid mt-4">
	<div class="row justify-content-center">
		<div class="col-12 col-md-8">
			<ul class="nav nav-pills nav-fill mb-4">
				<li class="nav-item">
					<a class="nav-link {{$tab=='home'?'active':''}}" href="/i/admin/reports/autospam">{{ __('admin_panel.reports.spam.tabActive') }}</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{$tab=='spam'?'active':''}}" href="/i/admin/reports/autospam?tab=spam">{{ __('admin_panel.reports.spam.tabSpam') }}</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{$tab=='not-spam'?'active':''}}" href="/i/admin/reports/autospam?tab=not-spam">{{ __('admin_panel.reports.spam.tabNotSpam') }}</a>
				</li>
				{{-- <li class="nav-item">
					<a class="nav-link" href="#">Closed</a>
				</li> --}}
				{{-- <li class="nav-item">
					<a class="nav-link" href="#">Review</a>
				</li> --}}
				{{-- <li class="nav-item">
					<a class="nav-link" href="#">Train</a>
				</li> --}}
				{{-- <li class="nav-item">
					<a class="nav-link {{$tab=='exemptions'?'active':''}}" href="/i/admin/reports/autospam?tab=exemptions">Exemptions</a>
				</li>
				<li class="nav-item">
					<a class="nav-link {{$tab=='custom'?'active':''}}" href="/i/admin/reports/autospam?tab=custom">Custom</a>
				</li>
				<li class="nav-item" style="max-width: 50px;">
					<a class="nav-link {{$tab=='settings'?'active':''}}" href="/i/admin/reports/autospam?tab=settings"><i class="far fa-cog"></i></a>
				</li> --}}
			</ul>
			<ul class="list-group">
				@if($appeals->count() == 0)
				<li class="list-group-item text-center py-5">
					<p class="mb-0 py-5 font-weight-bold">{{ __('admin_panel.reports.spam.empty') }}</p>
				</li>
				@endif
				@foreach($appeals as $appeal)
				<a class="list-group-item text-decoration-none text-dark" href="/i/admin/reports/autospam/{{$appeal->id}}">
					<div class="d-flex justify-content-between align-items-center">
						<div class="d-flex align-items-center">
							<img src="{{$appeal->has_media ? $appeal->status->thumb(true) : '/storage/no-preview.png'}}" width="64" height="64" class="rounded border" onerror="this.onerror=null;this.src='/storage/no-preview.png';">
							<div class="ml-3">
								<span class="d-inline-block text-truncate">
									<p class="mb-0 font-weight-bold">&commat;{{$appeal->user->username}}</p>
									<p class="mb-0 small text-muted font-weight-bold">{{$appeal->created_at->diffForHumans(null, null, true)}}</p>
								</span>
							</div>
						</div>
						<div class="d-block">
						</div>
						<div class="d-inline-block">
							<p class="mb-0 small">
								<i class="fas fa-chevron-right fa-2x text-lighter"></i>
							</p>
						</div>
					</div>
				</a>
				@endforeach
			</ul>
			<p>{!!$appeals->render()!!}</p>
		</div>
	</div>
</div>

@endsection
