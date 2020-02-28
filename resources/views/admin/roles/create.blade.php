@extends('ui.layouts.basic', ['title' => 'Create Role'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h3>Create Role</h3>
                <form class="pt-3" method="POST" action="{{ route('admin.permissions.store') }}" novalidate>
                    @csrf
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
                    <div class="row border border-dark p-3 bg-white">
                        @foreach ($permissionGroups as $group)
                            <div clas="col-md-3">
                                <a class="card-link" data-toggle="collapse" href="#permission-group-{{ $group->uuid }}" role="button" aria-expanded="false" aria-controls="permission-group-{{ $group->uuid }}">
                                    {{ $group->name }}
                                </a>
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
                        @endforeach
                    </div>
                    <div class="form-group mt-3 mb-0">
                        <button type="submit"
                                class="btn btn-block btn-primary">
                            Create Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
