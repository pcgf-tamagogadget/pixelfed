@extends('layouts.app')

@section('content')
<story-compose></story-compose>
@endsection

@push('scripts')
<script type="text/javascript">
	new Vue({ el: '#content', i18n: App.i18n() });
</script>
@endpush