@extends('ui.layouts.auth', ['title' => 'Verify Email'])

@section('content')
<div class="col-md-4 mx-auto">
    <div class="auth-form-light p-5">
        <p class="mt-2">
            Hi <b>{{ Auth::user()->last_name }}</b>,
        </p>
        <p>Check your email for instructions on how to verify and access your account.</p>
        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            @if (session('resent'))
                <div class="alert alert-success text-center">Instructions Resent to your Email</div>
            @endif
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-block btn-primary auth-form-btn">Resend Instructions</button>
            </div>
        </form>
        <div class="mt-3 text-center">
            <a href="{{ route('logout') }}" class="card-link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <small>Logout</small>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                    style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection
