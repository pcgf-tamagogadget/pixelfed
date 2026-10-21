@extends('admin.partial.template-full')

@section('section')
    <div class="title d-flex justify-content-between align-items-center">
        <span><a href="{{ route('admin.users') }}" class="btn btn-outline-secondary btn-sm font-weight-bold">{{ __('admin_panel.common.back') }}</a></span>
        <span class="text-center">
            <h3 class="font-weight-bold mb-0">{{ __('admin_panel.users.invites.create.title') }}</h3>
        </span>
        <span>&nbsp;</span>
    </div>
    <hr>
    <div class="col-12 col-md-8 offset-md-2">
        <div class="row">
            <div class="col-12">
                <form method="post">
                    @csrf
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">{{ __('admin_panel.users.invites.create.name') }}</label>
                        <input
                            type="text"
                            class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                            name="name"
                            placeholder="{{ __('admin_panel.users.invites.create.namePlaceholder') }}"
                            value="{{ old('name') }}"
                        />
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">{{ __('admin_panel.users.invites.create.description') }}</label>
                        <textarea
                            class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                            rows="2"
                            name="description"
                            maxlength="1000">{{ old('description') }}</textarea>
                        @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">{{ __('admin_panel.users.invites.create.message') }}</label>
                        <textarea
                            class="form-control{{ $errors->has('message') ? ' is-invalid' : '' }}"
                            rows="2"
                            name="message"
                            maxlength="1000">{{ old('message', __('admin_panel.users.invites.create.defaultMessage', ['app' => config('app.name')])) }}</textarea>
                        @error('message')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">{{ __('admin_panel.users.invites.create.email') }}</label>
                        <input
                            type="email"
                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                            name="email"
                            value="{{ old('email') }}"
                        />
                        <p class="help-text small text-muted font-weight-bold">{{ __('admin_panel.users.invites.create.emailHelp') }}</p>
                        @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">{{ __('admin_panel.users.invites.create.maxUses') }}</label>
                        <input
                            type="number"
                            min="0"
                            class="form-control{{ $errors->has('max_uses') ? ' is-invalid' : '' }}"
                            name="max_uses"
                            value="{{ old('max_uses', 1) }}"
                            required
                        />
                        <p class="help-text small text-muted font-weight-bold">{{ __('admin_panel.users.invites.create.maxUsesHelp') }}</p>
                        @error('max_uses')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold text-muted">{{ __('admin_panel.users.invites.create.expiresIn') }}</label>
                        <input
                            type="number"
                            min="0"
                            class="form-control{{ $errors->has('expires_in') ? ' is-invalid' : '' }}"
                            name="expires_in"
                            value="{{ old('expires_in', 0) }}"
                            required
                        />
                        <p class="help-text small text-muted font-weight-bold">{{ __('admin_panel.users.invites.create.expiresInHelp') }}</p>
                        @error('expires_in')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="skip_email_verification" name="skip_email_verification" value="1" @checked(old('skip_email_verification'))>
                            <label class="custom-control-label" for="skip_email_verification">{{ __('admin_panel.users.invites.create.skipEmailVerification') }}</label>
                        </div>
                        @error('skip_email_verification')
                        <span class="invalid-feedback" style="display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    <hr>
                    <p class="float-right">
                        <button type="submit" class="btn btn-primary font-weight-bold py-1">{{ __('admin_panel.users.invites.create.submit') }}</button>
                    </p>
                </form>
            </div>
        </div>
    </div>

@endsection
