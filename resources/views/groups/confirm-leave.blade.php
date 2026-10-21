@extends('layouts.app')

@section('content')
<div class="container mt-5">
	<div class="row justify-content-center">

		<div class="col-12 col-md-7">
			<p class="h3 font-weight-bold">{{ __('pages.groups.leave.title') }}</p>
			{{-- <p class="lead mb-3">If you decide to leave this group, all of your content will be permanently deleted.</p>
			<p class="lead font-weight-bold">All of your interactions will be removed, including group</p>
			<ul class="lead mb-5">
				<li>Posts</li>
				<li>Photos & Videos</li>
				<li>Comments</li>
				<li>Events</li>
				<li>Polls</li>
				<li>Likes</li>
				<li>Shares</li>
				<li>Reactions</li>
				<li>Group Invitations</li>
				<li>Moderation Reports</li>
				<li>Recommendations</li>
			</ul> --}}
			<p class="mb-1">{{ __('pages.groups.leave.contentRemains') }}</p>
			<p class="mb-3">{{ __('pages.groups.leave.rejoinLimit') }}</p>
			<hr>
			<form class="d-flex justify-content-between">
				<button class="btn btn-light border font-weight-bold" style="width: 75%;">{{ __('pages.groups.leave.cancel') }}</button>
				<button type="submit" class="btn btn-danger font-weight-bold">{{ __('pages.groups.leave.leave') }}</button>
			</form>
		</div>
	</div>
</div>
@endsection
