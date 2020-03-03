@extends('ui.layouts.basic', ['title' => 'Delete Role'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4">
            @include('admin.roles.includes.role')
            <form method="POST" action="{{ route('admin.roles.destroy', ['role' => $role->uuid]) }}" novalidate>
                @method('DELETE')
                @csrf
                <p class="text-danger text-center mt-4">
                    <i class="fas fa-info-circle fa-fw"></i>
                    Cannot be Undone
                    <i class="fas fa-info-circle fa-fw"></i>
                </p>
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-block btn-danger">
                        Delete Role
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-7 bg-white p-3">
            @include('admin.roles.includes.view')
        </div>
    </div>
@endsection
