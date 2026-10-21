@extends('admin.partial.template-full')

@section('section')
  <div class="title">
    <h3 class="font-weight-bold">{{ __('admin_panel.statuses.show.title', ['id' => $status->id]) }}</h3>
  </div>

  <hr>

  <div>
    <div class="btn-group" role="group">
      <button type="button" class="btn btn-outline-secondary">{{ __('admin_panel.statuses.show.viewDetails') }}</button>
      <button type="button" class="btn btn-outline-secondary">{{ __('admin_panel.statuses.show.viewUserStats') }}</button>
      <button type="button" class="btn btn-outline-danger">{{ __('admin_panel.common.delete') }}</button>
    </div>
  </div>

  @php($item = $status)
  @include('status.template')
@endsection

@push('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
      $('.human-size').each(function(d,a) {
        let el = $(a);
        let size = el.data('bytes');
        el.text(filesize(size, {round: 0}));
      });

      $('.status-card .card-footer').hide();
      $('.status-card .reactions').hide();
      $('.status-card .comments').hide();
    });
  </script>
@endpush