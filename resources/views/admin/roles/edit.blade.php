@extends('ui.layouts.basic', ['title' => 'Edit User'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h3>Edit User</h3>
                <form class="pt-3" method="POST" action="{{ route('admin.users.update', ['user' => $user->uuid]) }}" novalidate>
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="first_name" class="sr-only">First Name</label>
                        <input type="text" id="first_name" name="first_name"
                                class="form-control @error('first_name') is-invalid @enderror"
                                value="{{ old('first_name') ?? $user->first_name }}" required placeholder="First Name" autofocus>
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
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') ?? $user->email }}" required placeholder="Email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="border border-dark p-3">
                        @foreach ($roles as $role)
                            <div class="form-check">
                                <label class="form-check-label text-muted">
                                    <input type="checkbox" id="role-{{ $role->uuid }}" name="roles[]"
                                        value="{{ $role->id }}" class="form-check-input"
                                        {{ (old('roles') && in_array($role->id, old('roles')) || in_array($role->id, $currentRoles) ? 'checked' : null) }}>
                                    {{ $role->display_name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit"
                                class="btn btn-block btn-primary auth-form-btn">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
