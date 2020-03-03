@extends('ui.layouts.app', ['title' => 'Roles'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="clearfix">
                        <h1 class="float-left">Roles</h1>
                        <a href="{{ route('admin.roles.create') }}" class="float-right btn btn-primary btn-sm">
                            <i class="fas fa-fw fa-plus"></i> Role
                        </a>
                    </div>
                    <table id="roles" class="table table-hover dt-responsive nowrap"></table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#roles').DataTable({
                responsive: true,
                paging: false,
                scrollY: '50vh',
                scrollCollapse: true,
                ajax: '{{ route('admin.roles.index') }}',
                columns: [
                    {data: 'name', name: 'name'}
                ],
                fnDrawCallback: function (settings) {
                    $(settings.nTHead).hide();
                }
            });
        });
    </script>
@endpush
