@extends('ui.layouts.basic', ['title' => 'Create Role'])

@section('content')
    <div class="row">
        <div class="col">
            <form method="POST" action="{{ route('admin.roles.store') }}" novalidate>
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name" class="sr-only">Name</label>
                                    <input type="text" id="name" name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}" required placeholder="Name" autofocus>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                                @error('permissions')
                                <p class="text-danger text-center">At least one permission required.</p>
                                @enderror
                                <div class="form-group mb-0">
                                    <button type="submit"
                                            class="btn btn-block btn-primary">
                                        Create Role
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 bg-white">
                        <div class="row">
                            @foreach ($permissionGroups as $group)
                                @if ($group->permissions->count())
                                    <div class="col-md-6">
                                        <div class="p-3">
                                            <p>
                                                <a class="text-decoration-none"
                                                   data-toggle="collapse"
                                                   href="#permission-group-{{ $group->uuid }}"
                                                   role="button"
                                                   aria-expanded="false"
                                                   aria-controls="permission-group-{{ $group->uuid }}">
                                                    {{ $group->name }}
                                                </a>
                                            </p>
                                            <div class="collapse show" id="permission-group-{{ $group->uuid }}">
                                                @foreach ($group->permissions as $permission)
                                                    <div class="form-check mx-3">
                                                        <label class="form-check-label">
                                                            <input type="checkbox"
                                                                   id="permission-{{ $permission->uuid }}"
                                                                   name="permissions[]"
                                                                   value="{{ $permission->id }}"
                                                                   class="form-check-input"
                                                                    {{ (old('permissions') && in_array($permission->id, old('permissions'))) ? 'checked' : null }}>
                                                            {{ $permission->display_name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
