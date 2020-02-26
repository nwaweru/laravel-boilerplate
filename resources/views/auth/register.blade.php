@extends('ui.layouts.auth', ['title' => 'Create Account'])

@section('content')
    <div class="row flex-grow">
        <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                    <img src="{{ asset('img/purple-admin/logo.svg') }}" alt="{{ config('app.name') }}">
                </div>
                <h1>{{ __('Create Account') }}</h1>
                <form class="pt-3" method="POST" action="{{ route('register') }}" novalidate>
                    @csrf
                    <div class="form-group">
                        <label for="first_name" class="sr-only">{{ __('First Name') }}</label>
                        <input type="text" id="first_name" name="first_name"
                               class="form-control form-control-lg @error('first_name') is-invalid @enderror"
                               value="{{ old('first_name') }}" required placeholder="First Name" autofocus>
                        @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="sr-only">{{ __('Last Name') }}</label>
                        <input type="text" id="last_name" name="last_name"
                               class="form-control form-control-lg @error('last_name') is-invalid @enderror"
                               value="{{ old('last_name') }}" required placeholder="Last Name">
                        @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email" class="sr-only">{{ __('Email') }}</label>
                        <input type="email" id="email" name="email"
                               class="form-control form-control-lg @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required placeholder="Email">
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
                    <div class="mb-4">
                        <div class="form-check">
                            <label class="form-check-label text-muted">
                                <input type="checkbox" class="form-check-input"> I agree to all Terms & Conditions
                            </label>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit"
                                class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                            {{ __('Create Account') }}
                        </button>
                    </div>
                    <div class="text-center mt-4 font-weight-light">
                        Already have an account? <a href="{{ route('login') }}" class="card-link text-primary">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
