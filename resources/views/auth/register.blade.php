@extends('ui.layouts.auth', ['title' => 'Create Account'])

@section('content')
    <div class="row flex-grow">
        <div class="col-md-4 col-lg-3 mx-auto">
            <div class="auth-form-light p-5">
                <form method="POST" action="{{ route('register') }}" novalidate>
                    @csrf
                    <div class="form-group">
                        <label for="first_name" class="sr-only">First Name</label>
                        <input type="text" id="first_name" name="first_name"
                               class="form-control @error('first_name') is-invalid @enderror"
                               value="{{ old('first_name') }}" required placeholder="First Name" autofocus>
                        @error('first_name')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="sr-only">Last Name</label>
                        <input type="text" id="last_name" name="last_name"
                               class="form-control @error('last_name') is-invalid @enderror"
                               value="{{ old('last_name') }}" required placeholder="Last Name">
                        @error('last_name')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email" class="sr-only">Email</label>
                        <input type="email" id="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required placeholder="Email">
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
                    <button type="submit"
                            class="btn btn-block btn-primary">
                        Create Account
                    </button>
                    <div class="text-center mt-4">
                        Already have an account? <a href="{{ route('login') }}" class="card-link">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
