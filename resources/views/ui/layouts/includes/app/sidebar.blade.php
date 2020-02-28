<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="{{ route('profile.edit', ['user' => Auth::user()->uuid]) }}" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{ Auth::user()->gravatar }}"
                         alt="{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}">
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span>
                    <span class="text-secondary text-small"><small>{{ (Auth::user()->role) ? Auth::user()->role : Auth::user()->email }}</small></span>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <span class="menu-title">Dashboard</span>
                <i class="fas fa-home menu-icon"></i>
            </a>
        </li>
        @canany(['users.index', 'roles.index', 'permissions.index', 'auditing.index'])
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#setup" aria-expanded="false" aria-controls="setup">
                    <span class="menu-title">Settings</span>
                    <i class="fas fa-cogs menu-icon"></i>
                </a>
                <div class="collapse" id="setup">
                    <ul class="nav flex-column sub-menu">
                        @can('users.index')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.users.index') }}">Users</a>
                        </li>
                        @endcan
                        @can('roles.index')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.roles.index') }}">Roles</a>
                        </li>
                        @endcan
                        @can('permissions.index')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.permissions.index') }}">Permissions</a>
                        </li>
                        @endcan
                        @can('auditing.index')
                        <li class="nav-item divider"></li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.auditing.index') }}">Audits</a>
                        </li>
                        @endcan
                    </ul>
                </div>
            </li>
        @endcanany
    </ul>
</nav>
