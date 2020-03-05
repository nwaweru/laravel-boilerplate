@extends('ui.layouts.auth', ['title' => 'Reset Password'])

@section('content')
<div class="row flex-grow">
    <div class="col-md-4 mx-auto">
        <div class="auth-form-light p-5 border border-dark">
            @if (session('status'))
            <div class="alert alert-success text-center" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}" novalidate>
                @csrf
                <div class="form-group">
                    <label for="email" class="sr-only">Email</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="Email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-block btn-primary">
                    Send Password Reset Link
                </button>
                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="text-decoration-none">Login</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
