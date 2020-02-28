@extends('ui.layouts.basic', ['title' => 'Create Role'])

@section('content')
<div class="row">
    <div class="col">
        <form method="POST" action="{{ route('admin.permissions.store') }}" novalidate>
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-6 bg-white">
                    <div class="row">
                        @foreach ($permissionGroups as $group)
                            <div class="col-md-4">
                                <div class="p-3">
                                    <p>
                                        <a class="card-link" data-toggle="collapse" href="#permission-group-{{ $group->uuid }}" role="button" aria-expanded="false" aria-controls="permission-group-{{ $group->uuid }}">
                                            {{ $group->name }}
                                        </a>
                                    </p>
                                    <div class="collapse show" id="permission-group-{{ $group->uuid }}">
                                        @foreach ($group->permissions as $permission)
                                            <div class="form-check mx-3">
                                                <label class="form-check-label text-muted">
                                                    <input type="checkbox" id="permission-{{ $permission->uuid }}" name="permissions[]"
                                                        value="{{ $permission->id }}" class="form-check-input"
                                                        {{ (old('permissions') && in_array($permission->id, old('permissions'))) ? 'checked' : null }}>
                                                    {{ $permission->display_name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="pb-3">Create Role</h3>
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
                            <div class="form-group">
                                <label for="display_name" class="sr-only">Display Name</label>
                                <input type="text" id="display_name" name="display_name"
                                        class="form-control @error('display_name') is-invalid @enderror"
                                        value="{{ old('display_name') }}" required placeholder="Display Name">
                                @error('display_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group mt-3 mb-0">
                                <button type="submit"
                                        class="btn btn-block btn-primary">
                                    Create Role
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
