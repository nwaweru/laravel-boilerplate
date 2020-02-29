@extends('ui.layouts.basic', ['title' => 'Create Permission'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h3>Create Permission</h3>
                <form class="pt-3" method="POST" action="{{ route('admin.permissions.store') }}" novalidate>
                    @csrf
                    <div class="form-group">
                        <label for="permission_group" class="sr-only">Permission Group</label>
                        <select id="permission_group" name="permission_group"
                            class="form-control @error('permission_group') is-invalid @enderror" required>
                            <option value="">Select Permission Group</option>
                            @foreach($permissionGroups as $group)
                                <option value="{{ $group->id }}"
                                    {{ (old('permission_group') && old('permission_group') == $group->id) ? 'selected' : null }}>
                                {{ $group->name }}</option>
                            @endforeach
                        </select>
                        @error('permission_group')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name" class="sr-only">Name</label>
                        <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" required placeholder="Route" autofocus>
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
                    <div class="form-group mt-3">
                        <button type="submit"
                                class="btn btn-block btn-primary">
                            Create Permission
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
