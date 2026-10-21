@extends('admin.partial.template-full')

@section('section')
<div class="title">
	<h3 class="font-weight-bold d-inline-block">{{ __('admin_panel.profiles.home.title') }}</h3>
	<span class="float-right">
		<a class="btn btn-{{request()->input('layout')=='card'?'primary':'light'}} btn-sm" href="{{route('admin.profiles',[
			'layout'=>'card', 
			'search' => request()->input('search'),
			'page' => request()->input('page') ?? 1,
			'filter' => request()->filter,
			'order' => request()->order
			])}}">
			<i class="fas fa-th"></i>
		</a>
		<a class="btn btn-{{request()->input('layout')!=='card'?'primary':'light'}} btn-sm mr-3" href="{{route('admin.profiles',[
			'layout'=>'list', 
			'search' => request()->input('search'),
			'page' => request()->input('page') ?? 1,
			'filter' => request()->filter,
			'order' => request()->order
			])}}">
			<i class="fas fa-list"></i>
		</a>
		<div class="dropdown d-inline-block">
			<button class="btn btn-light btn-sm dropdown-toggle font-weight-bold" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="fas fa-filter"></i>
			</button>
			<div class="dropdown-menu dropdown-menu-right" aria-labelledby="filterDropdown" style="width: 300px;">
				<div class="dropdown-item">
					<form>
						<input type="hidden" name="layout" value="{{request()->input('layout')}}"></input>
						<input type="hidden" name="page" value="{{request()->input('page')}}"></input>
						<div class="input-group input-group-sm">
							<input class="form-control" name="search" placeholder="{{ __('admin_panel.profiles.home.filterByUsername') }}" autocomplete="off" value="{{request()->input('search')}}">
							<div class="input-group-append">
								<button class="btn btn-outline-primary" type="submit">{{ __('admin_panel.profiles.home.filter') }}</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</span>
</div>
<hr>
@if(request()->input('layout') !== 'card')
<div class="mb-3 bulk-actions d-none">
	<div class="d-flex justify-content-between">
		<span>
			<span class="bulk-count font-weight-bold" data-count="0">
				0
			</span>
			<span class="bulk-desc"> {{ __('admin_panel.profiles.home.itemsSelected') }}</span>
		</span>
		<span class="d-inline-flex">
			<select class="custom-select custom-select-sm font-weight-bold bulk-action">
				<option selected disabled="">{{ __('admin_panel.profiles.home.selectBulkAction') }}</option>
				<option value="1" disabled="">{{ __('admin_panel.profiles.home.reviewComingSoon') }}</option>
				<option value="2">{{ __('admin_panel.profiles.home.addCw') }}</option>
				<option value="3">{{ __('admin_panel.profiles.home.unlistFromTimelines') }}</option>
				<option value="4">{{ __('admin_panel.profiles.home.noAutolinking') }}</option>
				<option value="5">{{ __('admin_panel.profiles.home.suspend') }}</option>
				<option value="6">{{ __('admin_panel.common.delete') }}</option>
			</select>
			<a class="btn btn-outline-primary btn-sm ml-3 font-weight-bold apply-bulk" href="#">
				{{ __('admin_panel.profiles.home.apply') }}
			</a>
		</span>
	</div>
</div>
<div class="table-responsive">
	<table class="table">
		<thead class="bg-light">
			<tr>
				<th scope="col" class="border-0" width="10%">
					<span>{{ __('admin_panel.common.id') }}</span> 
				</th>
				<th scope="col" class="border-0" width="15%">
					<span>{{ __('admin_panel.common.username') }}</span>
				</th>
				<th scope="col" class="border-0" width="20%">
					<span>{{ __('admin_panel.profiles.home.followers') }}</span>
				</th>
				<th scope="col" class="border-0" width="20%">
					<span>{{ __('admin_panel.profiles.home.likes') }}</span>
				</th>
				<th scope="col" class="border-0" width="20%">
					<span>{{ __('admin_panel.profiles.home.statuses') }}</span>
				</th>
				<th scope="col" class="border-0" width="10%">
					<span>{{ __('admin_panel.profiles.home.storage') }}</span>
				</th>
				<th scope="col" class="border-0" width="10%">
					<span>{{ __('admin_panel.common.actions') }}</span>
				</th>
			</tr>
		</thead>
		@foreach($profiles as $profile)
		<tr class="font-weight-bold text-center user-row">
			<td>
				{{$profile->id}}
			</td>
			<td class="text-truncate" data-toggle="tooltip" data-placement="bottom" title="{{$profile->username}}" style="max-width: 150px;">
				{{$profile->username}}
			</td>
			<td>
				{{$profile->followers()->count()}}
			</td>
			<td>
				{{$profile->likes()->count()}}
			</td>
			<td>
				{{$profile->statuses()->count()}}
			</td>
			<td>
				<div class="filesize" data-size="{{$profile->media()->sum('size')}}">{{ __('admin_panel.profiles.home.bytes', ['size' => $profile->media()->sum('size')]) }}</div>
				
			</td>
			<td>
				<a class="btn btn-outline-secondary btn-sm py-0 mr-3" href="/i/admin/profiles/edit/{{$profile->id}}">{{ __('admin_panel.common.edit') }}</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>
<div class="d-flex justify-content-center mt-5 small">
	{{$profiles->appends([
		'layout'=>request()->layout,
		'search'=>request()->search,
		'filter'=>request()->filter,
		'order'=>request()->order
		])->links()}}
</div>
@else
<div class="row">
	@foreach($profiles as $profile)
	<div class="col-12 col-md-4 mb-4">
		<div class="card">
			<div class="card-header bg-white text-center" style="min-height: 80px">
				<img class="box-shadow rounded-circle mb-3" src="{{$profile->avatarUrl()}}" width="64px" height="64px">
				<p class="font-weight-bold mb-0 text-truncate">{{$profile->username}}</p>
			</div>
			<ul class="list-group list-group-flush small">
				<li class="list-group-item d-flex justify-content-between text-center">
					<div>
						<p class="font-weight-bold mb-0 h5">{{$profile->statuses()->count()}}</p>
						<span class="font-weight-bold text-muted" data-toggle="tooltip" title="{{ __('admin_panel.profiles.home.totalStatuses') }}"><i class="fas fa-sm fa-camera-retro"></i></span>
					</div>
					<div>
						<p class="font-weight-bold mb-0 h5 filesize" data-size="{{$profile->media()->sum('size')}}">0</p>
						<span class="font-weight-bold text-muted" data-toggle="tooltip" title="{{ __('admin_panel.profiles.home.storageSpaceUsed') }}"><i class="fas fa-sm fa-cloud-upload-alt"></i></span>
					</div>
					<div>
						<p class="font-weight-bold mb-0 h5">{{$profile->followers()->count()}}</p>
						<span class="font-weight-bold text-muted" data-toggle="tooltip" title="{{ __('admin_panel.profiles.home.totalFollowers') }}"><i class="fas fa-sm fa-user-plus"></i></span>	
					</div>
				</li>
				<li class="list-group-item text-center">
					<a class="btn btn-outline-primary btn-sm py-0" href="{{$profile->url()}}">{{ __('admin_panel.common.view') }}</a>
					<a class="btn btn-outline-secondary btn-sm py-0" href="/i/admin/profiles/edit/{{$profile->id}}">{{ __('admin_panel.common.edit') }}</a>
				</li>
			</ul>
		</div>
	</div>
	@endforeach
</div>
<div class="d-flex justify-content-center mt-5 small">
	{{$profiles->appends([
		'layout'=>request()->layout,
		'search'=>request()->search,
		'filter'=>request()->filter,
		'order'=>request()->order
		])->links()}}
</div>
@endif
@endsection

@push('styles')
<style type="text/css">

.user-row .action-row {
	display: none;
}

.user-row:hover,
.user-row-active {
	background-color: #eff8ff;
}
.user-row:hover .action-row {
	display: block;
}
.user-row:hover .last-active {
	display: none;
}
</style>
@endpush
@push('scripts')
<script type="text/javascript">
	$('.filesize').each(function(k,v) {
		$(this).text(filesize(v.getAttribute('data-size'), {unix:true, round:0}))
	});
	$('.col-ord').on('click', function(e) {
		e.preventDefault();
		let el = $(this);
		let ord = el.data('dir');
		let col = el.data('col');
		let wurl = new URL(window.location.href);
		let query_string = wurl.search;
		let search_params = new URLSearchParams(query_string); 

		if(ord == 'asc') {
			search_params.set('filter', col);
			search_params.set('order', ord);
			wurl.search = search_params.toString();
			el.find('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
			el.data('dir', 'desc');
		} else {
			search_params.set('filter', col);
			search_params.set('order', ord);
			wurl.search = search_params.toString();
			el.find('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
			el.data('dir', 'asc');
		}
		window.location.href = wurl.toString();
	});


	$(document).on('click', '#row-check-all', function(e) {
		return;
		let el = $(this);
		let attr = el.attr('checked');

		if (typeof attr !== typeof undefined && attr !== false) {
			$('tbody .user-row').removeClass('user-row-active');
			$('.bulk-actions').addClass('d-none');
			$('.row-check-item').removeAttr('checked').prop('checked', false);
			el.removeAttr('checked').prop('checked', false);
		} else {
			$('tbody .user-row').addClass('user-row-active');
			$('.bulk-actions').removeClass('d-none');
			el.attr('checked', '').prop('checked', true);
			$('.row-check-item').attr('checked', '').prop('checked', true);
		}

		let len = $('.row-check-item:checked').length;
		if(attr == true) {
			len--;
		}
		$('.bulk-count').text(len).attr('data-count', len);
	});


	$(document).on('click', '.row-check-item', function(e) {
		return;
		var el = $(this)[0];
		let len = $('.row-check-item:checked').length;
		if($('#row-check-all:checked').length > 0) {
			len--;
		}
		if($(this).hasClass('row-check-all')) {
			return;
		}
		if(el.checked == true) {
			$(this).parents().eq(2).addClass('user-row-active');
			$('.bulk-actions').removeClass('d-none');
			$('.bulk-count').text(len).attr('data-count', len);
		} else {
			$(this).parents().eq(2).removeClass('user-row-active');
			if(len == 0) {
				$('.bulk-actions').addClass('d-none');
			} else {
				$('.bulk-count').text(len).attr('data-count', len);   
			}
		}
		if(len == 0) {
			$('.bulk-actions').addClass('d-none');
			$('#row-check-all').prop('checked', false);
		} else {
			$('.bulk-actions').removeClass('d-none');
		}
	});

	$(document).on('click', '.apply-bulk', function(e) {
		return;
		e.preventDefault();
		let len = $('.row-check-item:checked').length;
		if($('#row-check-all:checked').length > 0) {
			len--;
		}
		if(len == 0) {
			return;
		}
		let action = $('.bulk-action').val();
		let ids = $('.row-check-item:checked').get().filter(i => {
			let el = $(i);
			if(el.hasClass('row-check-all')) {
				return false;
			}
			return true;
		}).map(i => {
			return $(i).data('id');
		});
		let actions = [
			'',
			'review',
			'cw',
			'unlist',
			'noautolink',
			'suspend',
			'delete'
		];
		action = actions[action];
		if(!action) {
			return;
		}
		swal(
			@json(__('admin_panel.profiles.home.confirm')), 
			@json(__('admin_panel.profiles.home.confirmAction')),
			'warning'
		).then(res => {
			console.log(action);
			console.log(ids);
		})
	});
</script>
@endpush
