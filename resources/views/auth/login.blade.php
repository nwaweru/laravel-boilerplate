@extends('ui.layouts.auth', ['title' => 'Login'])

@section('content')
    <div class="row flex-grow">
        <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                    <img src="{{ asset('img/purple-admin/logo.svg') }}" alt="{{ config('app.name') }}">
                </div>
                <p class="p-4 border border-success">
                    <b>Administrator Demo</b>
                    <br>
                    Email: <code>jane.doe@example.com</code>
                    <br>
                    Password: <code>password</code>
                    <br>
                    <small class="text-primary">Customizable in <code>UsersTableSeeder</code></small>
                </p>
                <h1>{{ __('Login') }}</h1>
                <form class="pt-3" method="POST" action="{{ route('login') }}" novalidate>
                    @csrf
                    <div class="form-group">
                        <label for="email" class="sr-only">{{ __('Email') }}</label>
                        <input type="email" id="email" name="email"
                               class="form-control form-control-lg @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required placeholder="Email" autofocus>
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
                    <div class="mt-3">
                        <button type="submit"
                                class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                            {{ __('Login') }}
                        </button>
                    </div>
                    <div class="my-2 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <label class="form-check-label text-muted" for="remember">
                                <input type="checkbox" id="remember" name="remember" class="form-check-input"
                                        {{ old('remember') ? 'checked' : '' }}>
                                {{ __('Keep me signed in') }}
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="auth-link card-link text-black" href="{{ route('password.request') }}">
                                {{ __('Reset your Password') }}
                            </a>
                        @endif
                    </div>
                    <div class="mb-2">
                        <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                            <i class="mdi mdi-facebook mr-2"></i>Connect using facebook
                        </button>
                    </div>
                    @if (Route::has('register'))
                        <div class="text-center mt-4 font-weight-light">
                            Don't have an account? <a href="{{ route('register') }}" class="card-link text-primary">Create
                                an Account</a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
