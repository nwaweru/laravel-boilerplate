<!DOCTYPE html>
<html lang="en">
@include('ui.includes.head')
<body>
<div id="app" class="container-scroller">
    @include('ui.includes.app.nav')
    <div class="container-fluid page-body-wrapper">
        @include('ui.includes.app.sidebar')
        <div class="main-panel">
            @include('ui.components.alert')
            <div class="content-wrapper">
                @yield('content')
            </div>
            @include('ui.includes.app.footer')
        </div>
    </div>
</div>
<script src="{{ asset('js/script.js') }}"></script>
@stack('scripts')
</body>
</html>
