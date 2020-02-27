@extends('ui.layouts.auth', ['title' => 'Reset Password'])

@section('content')
<div class="row flex-grow">
    <div class="col-lg-4 mx-auto">
        <div class="auth-form-light p-5">
            <h1>Reset Password</h1>
            @if (session('status'))
                <div class="alert alert-success mt-3 mb-0 text-center" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            <form class="pt-3" method="POST" action="{{ route('password.email') }}" novalidate>
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
                <div class="mt-3">
                    <button type="submit"
                            class="btn btn-block btn-primary auth-form-btn">
                        Send Password Reset Link
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
