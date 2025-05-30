<section>
    <header class="mb-4">
        <h2 class="h5 text-dark">
            {{ __('Update Password') }}
        </h2>
        <p class="text-muted small">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
            <input type="password" name="current_password" id="update_password_current_password" class="form-control" autocomplete="current-password">
            @if ($errors->updatePassword->has('current_password'))
                <div class="text-danger small mt-1">
                    {{ $errors->updatePassword->first('current_password') }}
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
            <input type="password" name="password" id="update_password_password" class="form-control" autocomplete="new-password">
            @if ($errors->updatePassword->has('password'))
                <div class="text-danger small mt-1">
                    {{ $errors->updatePassword->first('password') }}
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
            <input type="password" name="password_confirmation" id="update_password_password_confirmation" class="form-control" autocomplete="new-password">
            @if ($errors->updatePassword->has('password_confirmation'))
                <div class="text-danger small mt-1">
                    {{ $errors->updatePassword->first('password_confirmation') }}
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
                <span class="text-success small">
                    {{ __('Saved.') }}
                </span>
            @endif
        </div>
    </form>
</section>
