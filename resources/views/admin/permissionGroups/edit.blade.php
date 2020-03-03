@extends('ui.layouts.basic', ['title' => 'Edit Permission Group'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <form class="pt-3"
                          method="POST"
                          action="{{ route('admin.permissionGroups.update', ['permissionGroup' => $permissionGroup->uuid, 'permission' => Request::query('permission')]) }}"
                          novalidate>
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="name" class="sr-only">Group Name</label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') ?? $permissionGroup->name }}"
                                   required
                                   placeholder="Group Name"
                                   autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-block btn-primary">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
