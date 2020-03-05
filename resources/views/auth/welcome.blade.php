@extends('ui.layouts.auth', ['title' => 'Set Password'])

@section('content')
<div class="row flex-grow">
    <div class="col-md-4 mx-auto">
        <div class="auth-form-light p-5 border border-dark">
            <form class="pt-3" method="POST" action="{{ route('users.welcome', ['token' => $user->welcomeToken->token, 'email' => $user->email]) }}" novalidate>
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="password" class="sr-only">New Password</label>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required placeholder="New Password" autofocus>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password-confirm" class="sr-only">Confirm Password</label>
                    <input type="password" id="password-confirm" name="password_confirmation" class="form-control" required placeholder="Confirm Password">
                </div>
                <button type="submit" class="btn btn-block btn-primary">
                    Set Password
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
