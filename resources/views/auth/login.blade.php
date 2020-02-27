@extends('ui.layouts.auth', ['title' => 'Login'])

@section('content')
<div class="row flex-grow">
    <div class="col-lg-4 mx-auto">
        <div class="auth-form-light p-5">
            <h1>Login</h1>
            <form class="pt-3" method="POST" action="{{ route('login') }}" novalidate>
                @csrf
                <div class="form-group">
                    <label for="email" class="sr-only">Email</label>
                    <input type="email" id="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" required placeholder="Email" autofocus>
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
                <div class="form-group mt-3">
                    <button type="submit"
                            class="btn btn-block btn-primary auth-form-btn">
                        {{ __('Login') }}
                    </button>
                </div>
                @if (Route::has('password.request') || Route::has('register'))
                    <div class="row mt-4">
                        @if (Route::has('password.request'))
                            <div class="col-md-6 text-center">
                                <a class="card-link" href="{{ route('password.request') }}">
                                    Reset Password
                                </a>
                            </div>
                        @endif
                        @if (Route::has('register'))
                            <div class="col-md-6 text-center">
                                <a href="{{ route('register') }}" class="card-link">
                                    Create Account
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
