@extends('ui.layouts.profile', ['title' => $user->first_name . ' ' . $user->last_name . ' - ' . config('app.name')])

@section('view')
    <form class="bg-white p-4" method="POST" action="{{ route('users.update', ['user' => $user->uuid]) }}" novalidate>
        @method('PUT')
        @csrf
        <div class="form-group">
            <label for="first_name" class="sr-only">First Name</label>
            <input type="text"
                   id="first_name"
                   name="first_name"
                   class="form-control @error('first_name') is-invalid @enderror"
                   value="{{ old('first_name') ?? $user->first_name }}"
                   required
                   placeholder="First Name"
                   autofocus>
            @error('first_name')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="last_name" class="sr-only">Last Name</label>
            <input type="text"
                   id="last_name"
                   name="last_name"
                   class="form-control @error('last_name') is-invalid @enderror"
                   value="{{ old('last_name') ?? $user->last_name }}"
                   required
                   placeholder="Last Name">
            @error('last_name')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="email" class="sr-only">Email</label>
            <input type="email"
                   id="email"
                   name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') ?? $user->email }}"
                   required
                   placeholder="Email">
            @error('email')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
            @enderror
        </div>
        @can('users.edit')
            <div class="px-2">
                @foreach ($roles as $role)
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox"
                                   id="role-{{ $role->uuid }}"
                                   name="roles[]"
                                   value="{{ $role->id }}"
                                   class="form-check-input" {{ (old('roles') && in_array($role->id, old('roles')) || in_array($role->id, $currentRoles) ? 'checked' : null) }}>
                            {{ $role->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        @endcan
        <button type="submit" class="mt-4 btn btn-block btn-primary auth-form-btn">
            Save Changes
        </button>
    </form>
@endsection
