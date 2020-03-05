<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="{{ route('users.show', ['user' => Auth::user()->uuid]) }}" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{ Auth::user()->gravatar }}" alt="{{ Auth::user()->first_name }}">
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{ Auth::user()->first_name }}</span>
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
        <li class="nav-item {{ (Request::is('setup/users/*') || Request::is('users/*')) ? 'active' : null }}">
            <a class="nav-link" href="{{ route('users.index') }}">
                <span class="menu-title">Users</span>
                <i class="fas fa-user-tag menu-icon"></i>
            </a>
        </li>
        @endcan
        @canany(['permissionGroups.index', 'permissions.index', 'roles.index',])
        <li class="nav-item {{ (Request::is('setup/roles/*') || Request::is('setup/permissions/*') || Request::is('setup/permissionGroups/*')) ? 'active' : null }}">
            <a class="nav-link" href="{{ route('admin.permissions.index') }}">
                <span class="menu-title">Access Control</span>
                <i class="fas fa-clipboard-list menu-icon"></i>
            </a>
        </li>
        @endcan
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
