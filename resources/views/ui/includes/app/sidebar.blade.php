<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="{{ route('users.show', ['user' => Auth::user()->uuid]) }}" class="nav-link">
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
        @can('users.index')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}">
                    <span class="menu-title">Users</span>
                    <i class="fas fa-users-cog menu-icon"></i>
                </a>
            </li>
        @endcan

        @canany(['users.index', 'roles.index', 'permission_groups', 'permissions.index', 'auditing.index'])
            <li class="nav-item">
                <a class="nav-link"
                   data-toggle="collapse"
                   href="#settings-nav"
                   aria-expanded="false"
                   aria-controls="settings-nav">
                    <span class="menu-title">Setup</span>
                    <i class="fas fa-cogs menu-icon"></i>
                </a>
                <div class="collapse" id="settings-nav">
                    <ul class="nav flex-column sub-menu">
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
                    </ul>
                </div>
            </li>
        @endcanany

        @can('auditing.index')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.auditing.index') }}">
                    <span class="menu-title">Audits</span>
                    <i class="fas fa-clipboard-check menu-icon"></i>
                </a>
            </li>
        @endcan
    </ul>
</nav>
