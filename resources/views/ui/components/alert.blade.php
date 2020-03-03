@if (session('alert'))
    <div class="alert alert-{{ session('alert')->type }} mb-0 text-center" role="alert">
        {{ session('alert')->text }}
    </div>
@endif