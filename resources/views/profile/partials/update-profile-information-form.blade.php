<section>
    <header class="mb-4">
        <h2 class="h5 text-dark">
            {{ __('Profile Information') }}
        </h2>
        <p class="text-muted small">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    {{-- Form untuk kirim ulang verifikasi email --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- Form utama untuk update profile, tambahkan enctype untuk upload file --}}
    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                id="name"
                name="name"
                value="{{ old('name', $user->name) }}"
                required
                autofocus
                autocomplete="name"
            >
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                id="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                required
                autocomplete="username"
            >
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-warning small">
                        {{ __('Your email address is unverified.') }}
                        <button
                            form="send-verification"
                            class="btn btn-link p-0 m-0 align-baseline small"
                        >
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="text-success small mt-2">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Foto Profil --}}
        <div class="mb-3">
            <label for="photo" class="form-label">{{ __('Profile Photo') }}</label>
            <input
                type="file"
                class="form-control @error('photo') is-invalid @enderror"
                id="photo"
                name="photo"
                accept="image/*"
            >
            @error('photo')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            @if ($user->photo)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Profile Photo" style="max-height: 150px;">
                </div>
            @endif
        </div>

        {{-- Tombol Submit --}}
        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <span class="text-success small">
                    {{ __('Saved.') }}
                </span>
            @endif
        </div>
    </form>
</section>
