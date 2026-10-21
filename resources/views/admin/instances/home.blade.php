@extends('admin.partial.template-full')

@section('section')
</div>
<instances-component />
@endsection

@push('scripts')
<script type="text/javascript">
    new Vue({ el: '#panel', i18n: App.i18n() });
</script>
@endpush
