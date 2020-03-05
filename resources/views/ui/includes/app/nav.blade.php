<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="{{ route('home') }}">
            <img src="{{ asset('img/purple-admin/logo.svg') }}" alt="{{ config('app.name') }}" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="{{ route('home') }}">
            <img src="{{ asset('img/purple-admin/logo-mini.svg') }}" alt="{{ config('app.name') }}" />
        </a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-home" title="Dashboard"></i>
                </a>
            </li>
            <li class="nav-item nav-profile">
                <a class="nav-link" href="{{ route('users.show', ['user' => Auth::user()->uuid]) }}">
                    <div class="nav-profile-img">
                        <img src="{{ Auth::user()->gravatar }}" alt="{{ Auth::user()->first_name }}'s Profile">
                    </div>
                    <div class="nav-profile-text ml-2">
                        <p class="mb-1 text-black">{{ Auth::user()->first_name }}</p>
                    </div>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-power-off" title="Logout"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>
