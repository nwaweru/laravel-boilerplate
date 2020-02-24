@extends('ui.layouts.auth', ['title' => 'Reset Password'])

@section('content')
    <div class="row flex-grow">
        <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                    <img src="{{ asset('img/purple-admin/logo.svg') }}" alt="{{ config('app.name') }}">
                </div>
                <h4>{{ __('Reset Password') }}</h4>
                <form class="pt-3" method="POST" action="{{ route('password.update') }}" novalidate>
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group">
                        <label for="email" class="sr-only">{{ __('Email') }}</label>
                        <input type="email" id="email" name="email"
                               class="form-control form-control-lg @error('email') is-invalid @enderror"
                               value="{{ $email ?? old('email') }}" required placeholder="Email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password" class="sr-only">{{ __('Password') }}</label>
                        <input type="password" id="password" name="password"
                               class="form-control form-control-lg @error('password') is-invalid @enderror"
                               required placeholder="Password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-confirm" class="sr-only">{{ __('Confirm Password') }}</label>
                        <input type="password" id="password-confirm" name="password_confirmation"
                               class="form-control form-control-lg" required placeholder="Confirm Password">
                    </div>
                    <div class="mt-3">
                        <button type="submit"
                                class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                    <div class="text-center mt-4 font-weight-light">
                        <a href="{{ route('login') }}" class="card-link text-black">Login Instead</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
