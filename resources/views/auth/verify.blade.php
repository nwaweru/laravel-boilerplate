@extends('ui.layouts.auth', ['title' => 'Verify Email'])

@section('content')
<div class="col-md-4 mx-auto">
    <div class="auth-form-light p-5">
        <p class="mt-2">
            Hi <b>{{ Auth::user()->last_name }}</b>!
        </p>
        <p>Check your email and click on our verification link to access your account.</p>
        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            @if (session('resent'))
                <p class="text-success text-center">A fresh verification link has been sent to your e-mail address.</p>
            @endif
            <div class="mt-3">
                <button type="submit" class="btn btn-block btn-primary auth-form-btn">
                    Request New Link
                </button>
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
