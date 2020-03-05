@extends('ui.layouts.basic', ['title' => 'Create Permission'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <form class="pt-3" method="POST" action="{{ route('admin.permissions.store') }}" novalidate>
                    @csrf
                    <div class="form-group">
                        <label for="permission_group" class="sr-only">Group</label>
                        <select id="permission_group" name="permission_group" class="form-control @error('permission_group') is-invalid @enderror" required @if(Auth::user()->can('permissionGroups.create')) aria-describedby="permissionGroupHelp" @endif>
                            <option value="">Select Group</option>
                            @foreach($permissionGroups as $group)
                            <option value="{{ $group->id }}" {{ (old('permission_group') && old('permission_group') == $group->id || Request::query('permissionGroup') === $group->uuid) ? 'selected' : null }}>
                                {{ $group->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('permission_group')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        @can('permissionGroups.create')
                        <small id="permissionGroupHelp" class="form-text text-muted pt-2 px-4">
                            <a href="{{ route('admin.permissionGroups.create') }}" class="text-decoration-none">
                                Add Group
                            </a>
                        </small>
                        @endcan
                    </div>
                    <div class="form-group">
                        <label for="display_name" class="sr-only">Permission</label>
                        <input type="text" id="display_name" name="display_name" class="form-control @error('display_name') is-invalid @enderror" value="{{ old('display_name') }}" required placeholder="Permission">
                        @error('display_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name" class="sr-only">Route</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Route">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-block btn-primary">
                        Create Permission
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
