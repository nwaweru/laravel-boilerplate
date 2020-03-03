<!DOCTYPE html>
<html lang="en">
@include('ui.includes.head')
<body>
<div id="app" class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
            @yield('content')
        </div>
    </div>
</div>
<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
