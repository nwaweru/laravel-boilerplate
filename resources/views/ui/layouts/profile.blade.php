@extends('ui.layouts.basic')

@section('content')
    <div class="row justify-content-center no-gutters">
        <div class="col-md-2 mx-3">
            <div class="d-none d-md-block text-center">
                <img class="img-fluid rounded-circle w-100"
                     src="{{ (isset($user->gravatar)) ? $user->gravatar : asset('img/gravatar/default.png') }}"
                     alt="{{ (isset($user->first_name) && isset($user->last_name)) ? $user->first_name . ' ' . $user->last_name : 'User Gravatar' }}">
                @if (!app()->environment('local'))
                    <div class="text-dark mt-2">
                        <a href="http://gravatar.com" class="text-decoration-none" target="_blank">
                            <small>Edit Gravatar</small>
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-4 col-lg-3">
            @yield('view')

            @if(isset($user->id) && Route::currentRouteName() === 'users.show')
                <div class="clearfix px-4 pb-4 bg-white">
                    @if(Auth::user()->can('users.delete') && $user->id !== Auth::user()->id)
                        <a href="{{ route('users.delete', ['user' => $user->uuid]) }}"
                           class="card-link float-left text-danger">
                            <i class="fas fa-trash-alt" title="Delete"></i>
                        </a>
                    @endif
                    <a href="{{ route('users.edit', ['user' => $user->uuid]) }}" class="card-link float-right">
                        <i class="fas fa-edit" title="Edit"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
