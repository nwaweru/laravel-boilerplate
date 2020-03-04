@extends('ui.layouts.basic', ['title' => 'Edit Permission'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h3>Edit Permission</h3>
                    <form class="pt-3"
                          method="POST"
                          action="{{ route('admin.permissions.update', ['permission' => $permission->uuid]) }}"
                          novalidate>
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="permission_group" class="sr-only">Permission Group</label>
                            <select id="permission_group" name="permission_group"
                                    class="form-control @error('permission_group') is-invalid @enderror" required
                                    @if(Auth::user()->can('permissionGroups.edit')) aria-describedby="permissionGroupHelp" @endif>
                                <option value="">Select Permission Group</option>
                                @foreach($permissionGroups as $group)
                                    <option value="{{ $group->id }}"
                                            {{ (old('permission_group') && old('permission_group') == $group->id || $group->id == $permission->permissionGroup->id) ? 'selected' : null }}>
                                        {{ $group->name }}
                                    </option>
                                @endforeach
                            </select>
                            @can('permissionGroups.edit')
                                <small id="permissionGroupHelp" class="form-text text-muted pt-2 px-4">
                                    <a href="{{ route('admin.permissionGroups.edit', ['permissionGroup' => $permission->permissionGroup->uuid, 'permission' => $permission->uuid]) }}"
                                       class="text-decoration-none">
                                        Edit Permissions Group
                                    </a>
                                </small>
                            @endcan
                            @error('permission_group')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="name" class="sr-only">Name</label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') ?? $permission->name }}"
                                   required
                                   placeholder="Route"
                                   autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="display_name" class="sr-only">Display Name</label>
                            <input type="text"
                                   id="display_name"
                                   name="display_name"
                                   class="form-control @error('display_name') is-invalid @enderror"
                                   value="{{ old('display_name') ?? $permission->display_name }}"
                                   required
                                   placeholder="Display Name">
                            @error('display_name')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit"
                                    class="btn btn-block btn-primary">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
