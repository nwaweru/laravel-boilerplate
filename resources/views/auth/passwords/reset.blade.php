@extends('ui.layouts.auth', ['title' => 'Reset Password'])

@section('content')
<div class="row flex-grow">
    <div class="col-md-4 mx-auto">
        <div class="auth-form-light p-5">
            <h1>Reset Password</h1>
            <form class="pt-3" method="POST" action="{{ route('password.update') }}" novalidate>
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-group">
                    <label for="email" class="sr-only">Email</label>
                    <input type="email" id="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ $email ?? old('email') }}" required placeholder="Email">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
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
                        Reset Password
                    </button>
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="card-link">Login</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
