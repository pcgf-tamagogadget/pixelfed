@extends('layouts.app',['title' => $profile->username . " on " . config('app.name')])

@section('content')
@if (session('error'))
    <div class="alert alert-danger text-center font-weight-bold mb-0">
        {{ session('error') }}
    </div>
@endif

<profile profile-id="{{$profile->id}}" profile-username="{{$profile->username}}" :profile-settings="{{json_encode($settings)}}" profile-layout="{{$profile->profile_layout ?? 'metro'}}"></profile>
@if($profile->website)
<a class="d-none" href="{{$profile->website}}" rel="me">{{$profile->website}}</a>
@endif
@endsection

@push('meta')<meta property="og:description" content="{{$profile->bio}}">
  @if(false == $settings['crawlable'] || $profile->remote_url)
  <meta name="robots" content="noindex, nofollow">
  @else  <meta property="og:image" content="{{$profile->avatarUrl()}}">
    <link href="{{$profile->permalink('.atom')}}" rel="alternate" title="{{$profile->username}} on Pixelfed" type="application/atom+xml">
    <link href='{{$profile->permalink()}}' rel='alternate' type='application/activity+json'>
  @endif
@endpush

@push('styles')
<style type="text/css">
  body {
    background: #fff !important;
  }
  .navbar {
    border: none !important;
  }
</style>
@endpush

@push('scripts')
<script type="text/javascript" src="{{ mix('js/profile.js') }}"></script>
<script type="text/javascript" src="{{ mix('js/compose.js') }}"></script>
<script type="text/javascript">
  new Vue({
    el: '#content'
  });
</script>
@endpush
