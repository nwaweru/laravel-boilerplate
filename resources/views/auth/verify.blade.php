@extends('ui.layouts.auth', ['title' => 'Verify Email'])

@section('content')
    <div class="row flex-grow">
        <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                    <img src="{{ asset('img/purple-admin/logo.svg') }}" alt="{{ config('app.name') }}">
                </div>
                @if (session('resent'))
                    <hr class="w-25">
                    <p class="text-success text-center">A fresh verification link has been sent to {{ Auth::user()->name }}.</p>
                    <hr class="w-25">
                @endif
                <div class="mt-2">
                    <p>Hello <b>{{ Auth::user()->name }}</b>. You are almost ready to access <b>{{ config('app.name') }}</b>.</p>
                    <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                </div>
                <form class="pt-2" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <div class="mt-3">
                        <button type="submit"
                                class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                            {{ __('Request New Link') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
