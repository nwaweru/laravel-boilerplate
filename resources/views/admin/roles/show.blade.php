@extends('ui.layouts.basic', ['title' => 'Role ' . $role->name . ' - Permissions'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h3>Role {{ $role->name }}</h3>
                <nav class="nav">
                    <a class="nav-link text-dark" href="#">Permissions</a>
                    <a class="nav-link" href="#">Users</a>
                </nav>
                <hr>

                @include('admin.roles.includes.view')

                @canany(['roles.delete', 'roles.edit'])
                <hr class="w-25">
                <div class="clearfix">
                    @if (Auth::user()->can('roles.delete') && !in_array($role->name, $userRoles))
                        <a href="{{ route('admin.roles.delete', ['role' => $role->uuid]) }}" class="float-left btn btn-danger">Delete</a>
                    @endif
                    @can('roles.edit')
                        <a href="{{ route('admin.roles.edit', ['role' => $role->uuid]) }}" class="float-right btn btn-primary">Edit</a>
                    @endcan
                </div>
                @endcanany
            </div>
        </div>
    </div>
</div>
@endsection
