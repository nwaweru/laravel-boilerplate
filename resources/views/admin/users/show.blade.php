@extends('ui.layouts.basic', ['title' => $user->first_name . ' ' . $user->first_name])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h3>{{ $user->first_name . ' ' . $user->last_name }}</h3>

                @include('admin.users.includes.profile')
                
                @canany(['users.delete', 'users.edit'])
                <hr class="w-25">
                <div class="clearfix">
                    @if (Auth::user()->can('users.delete') && Auth::user()->id !== $user->id)
                        <a href="{{ route('admin.users.delete', ['user' => $user->uuid]) }}" class="float-left btn btn-danger">Delete</a>
                    @endif
                    @can('users.edit')
                        <a href="{{ route('admin.users.edit', ['user' => $user->uuid]) }}" class="float-right btn btn-primary">Edit</a>
                    @endcan
                </div>
                @endcanany
            </div>
        </div>
    </div>
</div>
@endsection
