@extends('ui.layouts.app', ['title' => 'Verify Email'])

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <p>Hi {{ Auth::user()->last_name }},</p>
                <p class="pb-3">Check your email for instructions on how to verify and access your account.</p>
                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    @if (session('resent'))
                        <div class="alert alert-success text-center">Instructions Resent to your Email</div>
                    @endif
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-block btn-primary auth-form-btn">Resend Instructions</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
