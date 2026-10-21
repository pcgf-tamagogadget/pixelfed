@extends('admin.partial.template-full')

@section('section')
</div><div class="header bg-primary pb-3 mt-n4">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <p class="display-1 text-white d-inline-block mb-0">{{ __('admin_panel.asf.create.title') }}</p>
                    <p class="text-white mb-0">{{ __('admin_panel.asf.create.subtitle') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="m-n2 m-lg-4">
        <div class="container-fluid mt-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li class="mb-0 font-weight-bold">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="card card-body">
                        <form method="post">
                            @csrf
                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('admin_panel.common.username') }}</label>
                                <input class="form-control" name="username" placeholder="{{ __('admin_panel.asf.create.usernamePlaceholder') }}" />
                            </div>

                            <p class="mb-0 font-weight-bold small">{{ __('admin_panel.asf.create.filters') }}</p>
                            <div class="list-group mb-3">
                                <div class="list-group-item">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="hide_from_public_feeds" name="hide_from_public_feeds">
                                        <label class="custom-control-label" for="hide_from_public_feeds">{{ __('admin_panel.asf.create.hidePublicPosts') }}</label>
                                    </div>
                                </div>
                                {{-- <div class="list-group-item"></div> --}}
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">{{ __('admin_panel.asf.create.note') }}</label>
                                <textarea class="form-control" name="note" placeholder="{{ __('admin_panel.asf.create.notePlaceholder') }}"></textarea>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="active" name="active" checked>
                                <label class="custom-control-label font-weight-bold" for="active">{{ __('admin_panel.asf.create.markAsActive') }}</label>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-success">{{ __('admin_panel.common.save') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
