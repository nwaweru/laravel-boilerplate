@extends('ui.layouts.basic', ['title' => 'View Role'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4">
            @include('admin.roles.includes.role')
            @canany(['roles.delete', 'roles.edit'])
                <div class="clearfix mt-2 mx-4">
                    @if (Auth::user()->can('roles.delete') && !in_array($role->name, $userRoles))
                        <a href="{{ route('admin.roles.delete', ['role' => $role->uuid]) }}"
                           class="card-link float-left text-danger">
                            <i class="fas fa-trash-alt" title="Delete"></i>
                        </a>
                    @endif
                    @can('roles.edit')
                        <a href="{{ route('admin.roles.edit', ['role' => $role->uuid]) }}"
                           class="card-link float-right">
                            <i class="fas fa-edit" title="Edit"></i>
                        </a>
                    @endcan
                </div>
            @endcanany
        </div>
        <div class="col-md-7 bg-white p-3">
            @include('admin.roles.includes.view')
        </div>
    </div>
@endsection
