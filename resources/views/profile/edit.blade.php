@extends('ui.layouts.basic', ['title' => $user->first_name . ' ' . $user->last_name])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-3 d-none d-md-block">
        <img src="{{ $user->gravatar }}" class="img-fluid rounded-circle w-100" alt="{{ $user->first_name . ' ' . $user->last_name }}">
        <p class="p-1 mt-3 bg-white text-center border border-dark">
            <small>Avatar managed using <a href="http://gravatar.com" class="card-link" target="_blank">Gravatar</a></small>
        </p>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h3>My Profile</h3>
                <form class="pt-3" method="POST" action="{{ route('profile.update', ['user' => $user->uuid]) }}" novalidate>
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="first_name" class="sr-only">{{ __('First Name') }}</label>
                        <input type="text" id="first_name" name="first_name"
                                class="form-control form-control-lg @error('first_name') is-invalid @enderror"
                                value="{{ old('first_name') ?? $user->first_name }}" required placeholder="First Name" autofocus>
                        @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="sr-only">{{ __('Last Name') }}</label>
                        <input type="text" id="last_name" name="last_name"
                                class="form-control form-control-lg @error('last_name') is-invalid @enderror"
                                value="{{ old('last_name') ?? $user->last_name }}" required placeholder="Last Name">
                        @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email" class="sr-only">Email</label>
                        <input type="email" id="email" name="email"
                                class="form-control form-control-lg @error('email') is-invalid @enderror"
                                value="{{ old('email') ?? $user->email }}" required placeholder="Email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mt-3">
                        <button type="submit"
                                class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                            {{ __('Save Changes') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
