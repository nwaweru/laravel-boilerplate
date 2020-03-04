@extends('ui.layouts.profile', ['title' => $user->first_name . ' ' . $user->last_name . ' - ' . config('app.name')])

@section('view')
    <blockquote class="blockquote bg-white mb-0 border-white">
        <p class="lead mb-0">
            <a href="{{ route('users.show', ['user' => $user->uuid]) }}"
               class="text-decoration-none">{{ $user->first_name . ' ' . $user->last_name}}</a>
        </p>
        <footer class="blockquote-footer">
            <small>{{ $user->email }}</small>
        </footer>
    </blockquote>

    @if(Auth::user()->can('roles.show') && $user->roles->count())
        <div class="px-5 pb-4 bg-white">
            @foreach($user->roles as $role)
                <p class="clearfix mb-0">
                    <a href="#collapse-{{ $role->uuid }}"
                       class="card-link float-left"
                       data-toggle="collapse"
                       title="User Role">
                        {{ $role->name }}
                    </a>
                    <small class="float-right">
                        <a href="{{ route('admin.roles.show', ['role' => $role->uuid]) }}" title="Permissions">
                            <i class="fas fa-fw fa-info-circle"></i>
                        </a>
                    </small>
                </p>
                <div class="collapse ml-3" id="collapse-{{ $role->uuid }}">
                    @foreach($role->permissions as $index => $permission)
                        <p class="m-0">- {{ $permission->display_name }}</p>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endif

    @yield('action')
@endsection
