@extends('settings.template')

@section('section')

  <div class="title">
    <h3 class="font-weight-bold">{{ __('settings.privacy.blocked_instances_title') }}</h3>
  </div>
  <hr>
  <div class="form-group pb-1">
    <p>
      <a class="btn btn-outline-secondary py-0 font-weight-bold" href="{{route('settings.privacy.muted-users')}}">{{ __('settings.privacy.muted_users') }}</a>
      <a class="btn btn-outline-secondary py-0 font-weight-bold" href="{{route('settings.privacy.blocked-users')}}">{{ __('settings.privacy.blocked_users') }}</a>
      <a class="btn btn-outline-secondary py-0 font-weight-bold" href="{{route('settings.privacy.blocked-keywords')}}">{{ __('settings.privacy.blocked_keywords') }}</a>
      <a class="btn btn-outline-primary py-0 font-weight-bold" href="{{route('settings.privacy.blocked-instances')}}">{{ __('settings.privacy.blocked_instances') }}</a>
    </p>
  </div>
  @if($filters->count() > 0)
  <ul class="list-group list-group-flush">
    @foreach($filters as $filter)
    <li class="list-group-item">
      <div class="d-flex justify-content-between align-items-center font-weight-bold">
        <span>
          <span class="pr-5">{{$filter->id}}</span>
          <span>{{$filter->instance->domain}}</span>
        </span>
        <span class="btn-group">
          <form action="{{route('settings.privacy.blocked-instances.unblock')}}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{$filter->id}}">
            <button type="submit" class="btn btn-outline-secondary btn-sm px-3 font-weight-bold">{{ __('settings.privacy.unblock') }}</button>
          </form>
        </span>
      </div> 
    </li>
    @endforeach
  </ul>
  <div class="d-flex justify-content-center mt-3 font-weight-bold">
    {{$filters->links()}}
  </div>
    <p>
      <button type="button" class="btn btn-primary font-weight-bold px-3 blockInstance">{{ __('settings.privacy.block_instance') }}</button>
    </p>
  @else
    <p>{!! __('settings.privacy.you_can_block_entire_instances_etc', ['url' => '#']) !!}</p>
    <p class="lead mb-4">{!! __('settings.privacy.you_are_not_blocking_any_instances_etc', ['url' => '#']) !!}</p>
    <p>
      <button type="button" class="btn btn-primary font-weight-bold px-3 blockInstance">{{ __('settings.privacy.block_instance') }}</button>
    </p>
  @endif

@endsection

@push('scripts')

<script type="text/javascript">
  $(document).ready(function() {
      $('.blockInstance').on('click', function() {
      swal({
        text: @json(__('settings.privacy.add_domain_to_block')),
        content: "input",
        button: {
          text: @json(__('settings.privacy.block')),
          closeModal: false,
        },
      })
      .then(val => {
        if (!val) {
          swal.stopLoading();
          swal.close();
          return;
        }
        let msg = @json(__('settings.privacy.the_url_you_have_entered_is_not_valid_etc'))
        try {
          let validator = new URL(val);
          if(!validator.hostname || validator.protocol != 'https:') {
            swal.stopLoading();
            swal.close();
            swal(@json(__('settings.privacy.invalid_url')), msg, 'error');
            return;
          }
          axios.post(window.location.href, {
            domain: validator.href
          }).then(res => {
            window.location.href = window.location.href;
          }).catch(err => {
            swal.stopLoading();
            swal.close();
            swal(@json(__('settings.privacy.invalid_url')), msg, 'error');
            return;
          });
        } catch(e) {
          swal.stopLoading();
          swal.close();
          swal(@json(__('settings.privacy.invalid_url')), msg, 'error');
        }
      })
    });
  });
</script>

@endpush