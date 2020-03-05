@extends('ui.layouts.app', ['title' => 'Verify Email'])

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card border border-dark">
            <div class="card-body">
                <p>Hi {{ Auth::user()->first_name }},</p>
                <p class="pb-3">Check your email for instructions on how to verify and access your account.</p>
                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    @if (session('resent'))
                    <div class="alert alert-success text-center">Instructions Resent to your Email</div>
                    @endif
                    <button type="submit" class="btn btn-block btn-primary">Resend Instructions
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
