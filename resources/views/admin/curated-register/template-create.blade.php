@extends('admin.partial.template-full')

@section('section')
</div><div class="header bg-primary pb-3 mt-n4">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-8 col-12">
                    <p class="display-1 text-white d-inline-block mb-0">{{ __('admin_panel.curatedRegister.shared.title') }}</p>
                    <p class="text-white mb-0">{{ __('admin_panel.curatedRegister.shared.tagline') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@if((bool) config_cache('instance.curated_registration.enabled'))
<div class="m-n2 m-lg-4">
    <div class="container-fluid mt-4">
        @include('admin.curated-register.partials.nav')

        <div class="row justify-content-center">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="display-4">{{ __('admin_panel.curatedRegister.templateCreate.title') }}</h2>
                        <p class="lead my-0">{{ __('admin_panel.curatedRegister.templateCreate.lead') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <p class="font-weight-bold mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        <form method="post">
                            @csrf

                            <div class="form-group">
                                <label class="small font-weight-bold">{{ __('admin_panel.curatedRegister.templateForm.shortcutName') }}</label>
                                <input
                                    class="form-control"
                                    name="name"
                                    value="{{old('name')}}"
                                    placeholder="{{ __('admin_panel.curatedRegister.templateForm.shortcutNamePlaceholder') }}" />
                            </div>

                            <div class="form-group">
                                <label class="small font-weight-bold">{{ __('admin_panel.curatedRegister.templateForm.content') }}</label>
                                <textarea
                                    class="form-control"
                                    name="content"
                                    value="{{old('content')}}"
                                    rows="8"
                                    placeholder="{{ __('admin_panel.curatedRegister.templateForm.contentPlaceholder') }}"></textarea>
                            </div>

                            <p class="font-weight-bold">
                                <a class="font-weight-bold small" data-toggle="collapse" href="#collapseDescription" aria-expanded="false" aria-controls="collapseDescription">
                                    {{ __('admin_panel.curatedRegister.templateForm.addDescription') }}
                                </a>
                            </p>

                            <div class="collapse" id="collapseDescription">
                                <div class="form-group">
                                    <label class="small font-weight-bold">{{ __('admin_panel.curatedRegister.templateForm.description') }}</label>
                                    <textarea
                                        class="form-control"
                                        name="description"
                                        rows="4"
                                        placeholder="{{ __('admin_panel.curatedRegister.templateForm.descriptionPlaceholder') }}"></textarea>
                                </div>
                            </div>

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="active" name="active" checked>
                                <label class="custom-control-label font-weight-bold" for="active">{{ __('admin_panel.curatedRegister.templateForm.markAsActive') }}</label>
                            </div>

                            <hr>
                            <button class="btn btn-primary btn-block rounded-pill font-weight-bold">{{ __('admin_panel.curatedRegister.templateCreate.title') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
