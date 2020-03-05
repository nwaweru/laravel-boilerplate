@extends('ui.layouts.auth', ['title' => 'Login'])

@section('content')
    <div class="row flex-grow">
        <div class="col-md-4 mx-auto">
            <div class="auth-form-light p-5 border border-dark">
                <form method="POST" action="{{ route('login') }}" novalidate>
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
                    <button type="submit"
                            class="btn btn-block btn-primary">
                        {{ __('Login') }}
                    </button>
                    @if (Route::has('password.request') || Route::has('register'))
                        <div class="clearfix mt-4 text-center">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-decoration-none float-left">
                                    Reset Password
                                </a>
                            @endif
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-decoration-none float-right">
                                    Create Account
                                </a>
                            @endif
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
