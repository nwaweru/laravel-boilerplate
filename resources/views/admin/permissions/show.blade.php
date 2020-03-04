@extends('ui.layouts.basic', ['title' => $permission->display_name])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                @include('admin.permissions.includes.view')

                @canany(['permissions.delete', 'permissions.edit'])
                <hr class="w-25">
                <div class="clearfix">
                    @can('permissions.edit')
                    <a href="{{ route('admin.permissions.edit', ['permission' => $permission->uuid]) }}" class="float-left btn btn-primary">Edit</a>
                    @endcan
                    @if (Auth::user()->can('permissions.delete') && !in_array($permission->name, $userPermissions))
                    <a href="{{ route('admin.permissions.delete', ['permission' => $permission->uuid]) }}" class="float-right btn btn-danger">Delete</a>
                    @endif
                </div>
                @endcanany
            </div>
        </div>
    </div>
</div>
@endsection
