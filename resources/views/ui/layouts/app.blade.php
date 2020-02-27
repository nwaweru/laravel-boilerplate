<!DOCTYPE html>
<html lang="en">
@include('ui.layouts.includes.head')
<body>
<div id="app" class="container-scroller">
    @include('ui.layouts.includes.app.nav')
    <div class="container-fluid page-body-wrapper">
        @include('ui.layouts.includes.app.sidebar')
        <div class="main-panel">
            <div class="content-wrapper">
                @include('ui.layouts.includes.app.header')
                @yield('content')
            </div>
            @include('ui.layouts.includes.app.footer')
        </div>
    </div>
</div>
<script src="{{ asset('js/script.js') }}"></script>
@stack('scripts')
</body>
</html>
