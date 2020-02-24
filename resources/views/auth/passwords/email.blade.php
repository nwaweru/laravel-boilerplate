@extends('ui.layouts.auth', ['title' => 'Reset Password'])

@section('content')
    <div class="row flex-grow">
        <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                    <img src="{{ asset('img/purple-admin/logo.svg') }}" alt="{{ config('app.name') }}">
                </div>
                <h4>{{ __('Reset Password') }}</h4>
                @if (session('status'))
                    <div class="alert alert-success mt-3 mb-0" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <form class="pt-3" method="POST" action="{{ route('password.email') }}" novalidate>
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
                    <div class="mt-3">
                        <button type="submit"
                                class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                            {{ __('Send Password Reset Link') }}
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
