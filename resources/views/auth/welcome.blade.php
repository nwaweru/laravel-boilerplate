@extends('ui.layouts.auth', ['title' => 'Set Password'])

@section('content')
<div class="row flex-grow">
    <div class="col-md-4 mx-auto">
        <div class="auth-form-light p-5">
            <div class="p-3 mb-0">
                <p>Hi {{ $user->first_name }},</p>
                <p class="mb-0">Set a password to access your {{ config('app.name') }} account.</p>
            </div>
            <form class="pt-3" method="POST" action="{{ route('users.welcome', ['token' => $user->welcomeToken->token, 'email' => $user->email]) }}" novalidate>
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" id="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required placeholder="Password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password-confirm" class="sr-only">Confirm Password</label>
                    <input type="password" id="password-confirm" name="password_confirmation"
                            class="form-control" required placeholder="Confirm Password">
                </div>
                <div class="mt-3">
                    <button type="submit"
                            class="btn btn-block btn-primary auth-form-btn">
                        Set Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
