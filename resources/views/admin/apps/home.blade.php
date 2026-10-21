@extends('admin.partial.template-full')

@section('section')
<div class="title">
	<h3 class="font-weight-bold d-inline-block">{{ __('admin_panel.apps.home.title') }}</h3>
	<span class="float-right">
		<div class="dropdown">
			<button class="btn btn-light btn-sm dropdown-toggle font-weight-bold" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			  <i class="fas fa-filter"></i>
			</button>
			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="filterDropdown">
				<a class="dropdown-item font-weight-light" href="{{route('admin.apps')}}?filter=revoked">{{ __('admin_panel.apps.home.showOnlyRevoked') }}</a>
				<a class="dropdown-item font-weight-light" href="{{route('admin.apps')}}">{{ __('admin_panel.apps.home.showAll') }}</a>
			</div>
		</div>
	</span>
</div>

<hr>
<div class="table-responsive">
  <table class="table">
    <thead class="bg-light">
      <tr>
        <th scope="col">#</th>
        <th scope="col">{{ __('admin_panel.apps.home.owner') }}</th>
        <th scope="col" width="25%">{{ __('admin_panel.apps.home.name') }}</th>
        <th scope="col">{{ __('admin_panel.apps.home.callbackUrl') }}</th>
        <th scope="col">{{ __('admin_panel.apps.home.revoked') }}</th>
        <th scope="col">{{ __('admin_panel.common.created') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach($apps as $app)
      <tr>
        <td>
          <a href="/i/admin/apps/show/{{$app->id}}" class="btn btn-sm btn-outline-primary">
           	{{$app->id}}
          </a>
        </td>
        <td class="font-weight-bold"><a href="{{$app->user->url()}}">{{$app->user->username}}</a></td>
        <td class="font-weight-bold">{{$app->name}}</td>
        <td class="font-weight-bold">{{Str::limit($app->redirect, 30)}}</td>
        <td class="font-weight-bold">{{ $app->revoked ? __('admin_panel.common.yes') : __('admin_panel.common.no') }}</td>
        <td class="font-weight-bold">{{now()->parse($app->created_at)->diffForHumans()}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection