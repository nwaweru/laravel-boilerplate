@extends('ui.layouts.basic', ['title' => 'Delete Role'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h3 class="text-danger">Delete Role?</h3>
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-right">Name:</td>
                            <td><b>{{ $role->name }}</b></td>
                        </tr>
                        <tr>
                            <td class="text-right">Permissions:</td>
                            <td><b>{{ $role->count() }}</b></td>
                        </tr>
                        <tr>
                            <td class="text-right">Users:</td>
                            <td><b>xxx</b></td>
                        </tr>
                    </table>
                </div>
                <form method="POST" action="{{ route('admin.roles.destroy', ['role' => $role->uuid]) }}" novalidate>
                    @method('DELETE')
                    @csrf
                    <p class="text-danger text-center">
                        <i class="fas fa-info-circle fa-fw"></i>
                        Cannot be Undone
                        <i class="fas fa-info-circle fa-fw"></i>
                    </p>
                    <div class="form-group mt-3 mb-0">
                        <button type="submit"
                                class="btn btn-block btn-danger">
                            Delete Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7 bg-white p-3">
        @include('admin.roles.includes.view')
    </div>
</div>
@endsection
