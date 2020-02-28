@extends('setup.users.layout', ['title' => 'Edit ' . $user->first_name . ' ' . $user->last_name])

@section('partial')
<form method="POST" action="{{ route('users.update', ['user' => $user->uuid]) }}">
    @csrf
    @method('put')
    <div class="row">
        <div class="form-group col-md-6">
            <label for="first_name">{{ __('First Name') }}</label>
            <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ (old('first_name')) ? old('first_name') : $user->first_name }}" placeholder="First Name" autofocus>
            @error('first_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="last_name">{{ __('Last Name') }}</label>
            <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ (old('last_name')) ? old('last_name') : $user->last_name }}" placeholder="Last Name">
            @error('last_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group">
        <label for="email">{{ __('Email') }}</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ (old('email')) ? old('email') : $user->email }}" placeholder="Email" aria-describedby="emailHelp">
        @if (!auth()->user()->can('users.index'))
        <small id="emailHelp" class="form-text text-danger">New emails require verification. Edit with caution.</small>
        @endif
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    @can('users.index')
    <hr class="w-25">
    <p class="mb-0">Roles</p>
    @foreach ($roles as $role)
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="role-{{ $role->uuid }}" name="roles[]" value="{{ $role->id }}" {{ (old('roles') && in_array($role->id, old('roles')) || in_array($role->id, $currentRoles) ? 'checked' : null) }}>
            <label class="form-check-label" for="role-{{ $role->uuid }}">{{ $role->display_name }}</label>
        </div>
    @endforeach
    @error('roles')
        <p class="text-danger font-weight-bold">{{ $message }}</p>
    @enderror
    @endcan
    <hr class="w-25">
    <div class="row justify-content-center">
        <div class="form-group col-md-6">
            <button type="submit" class="btn btn-primary btn-block">{{ __('Save Changes') }}</button>
        </div>
    </div>
</form>
@endsection
