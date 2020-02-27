<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="{{ route('home') }}" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{ Auth::user()->gravatar }}"
                         alt="{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}">
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</span>
                    <span class="text-secondary text-small">{{ Auth::user()->role }}</span>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <span class="menu-title">Dashboard</span>
                <i class="fas fa-home menu-icon"></i>
            </a>
        </li>
        @canany(['users.index', 'roles.index', 'auditing.index'])
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#setup" aria-expanded="false" aria-controls="setup">
                    <span class="menu-title">Admin</span>
                    <i class="fas fa-wrench menu-icon"></i>
                </a>
                <div class="collapse" id="setup">
                    <ul class="nav flex-column sub-menu">
                        @can('users.index')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.index') }}">Users</a>
                        </li>
                        @endcan
                        @can('roles.index')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('roles.index') }}">Roles</a>
                        </li>
                        @endcan
                        @can('auditing.index')
                        <li class="nav-item divider"></li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('auditing.index') }}">Audits</a>
                        </li>
                        @endcan
                    </ul>
                </div>
            </li>
        @endcanany
    </ul>
</nav>
