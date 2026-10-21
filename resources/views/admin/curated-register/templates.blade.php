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

        <div class="row">
            <div class="col-12">
                @if (session('status'))
                    <div class="alert alert-success font-weight-bold lead" id="shm">
                        {{ session('status') }}
                    </div>
                    <script>
                        setTimeout(() => document.getElementById('shm').classList.add('animate__animated', 'animate__bounceOutLeft'), 2000);
                        setTimeout(() => document.getElementById('shm').style.display = 'none', 2500);
                    </script>
                @endif
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <p class="lead my-0">{{ __('admin_panel.curatedRegister.templates.lead') }}</p>
                        <a class="btn btn-primary font-weight-bold rounded-pill" href="{{route('admin.curated-onboarding.create-template')}}">{{ __('admin_panel.curatedRegister.templates.createNew') }}</a>
                    </div>
                </div>
            </div>

            <div class="col-12">

                <div class="table-responsive rounded">
                    <table class="table table-dark">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">{{ __('admin_panel.common.id') }}</th>
                                <th scope="col">{{ __('admin_panel.curatedRegister.templateForm.shortcutName') }}</th>
                                <th scope="col">{{ __('admin_panel.curatedRegister.templateForm.content') }}</th>
                                <th scope="col">{{ __('admin_panel.curatedRegister.templates.active') }}</th>
                                <th scope="col">{{ __('admin_panel.common.created') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($templates as $template)
                            <tr>
                                <td class="align-middle">
                                    <a
                                        href="/i/admin/curated-onboarding/templates/edit/{{$template->id}}"
                                        class="font-weight-bold">
                                        {{ $template->id }}
                                    </a>
                                </td>
                                <td class="align-middle">
                                    {{ $template->name }}
                                </td>
                                <td class="align-middle">
                                    {{ Str::limit($template->content, 80) }}
                                </td>
                                <td class="align-middle">
                                    {{ $template->is_active ? '✅' : '❌' }}
                                </td>
                                <td class="align-middle">
                                    {{ $template->created_at->format('M d Y') }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex mt-3">
                        {{ $templates->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
