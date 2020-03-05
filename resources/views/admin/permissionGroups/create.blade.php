@extends('ui.layouts.basic', ['title' => 'Create Permission Group'])

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.permissionGroups.store') }}" novalidate>
                    <input type="hidden" name="permission" value="{{ Request::query('permission') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="sr-only">Name</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Name" autofocus>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-block btn-primary">
                        Create Group
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
