@extends('ui.layouts.app', ['title' => 'Permissions'])

@section('content')
    <div class="row">
        <div class="col-md-4">
            <table id="roles" class="table table-borderless dt-responsive nowrap bg-white"></table>
            @can('roles.create')
                <a href="{{ route('admin.roles.create') }}"
                   class="btn btn-primary btn-sm mt-2">
                    <i class="fas fa-fw fa-plus"></i> Role
                </a>
            @endcan
        </div>
        <div class="col-md-8">
            <table id="permissions" class="table table-borderless dt-responsive nowrap bg-white">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Group</th>
                    <th scope="col">Permission</th>
                    <th scope="col">Route</th>
                </tr>
                </thead>
            </table>
            @can('permissions.create')
                <p class="text-right">
                    <a href="{{ route('admin.permissions.create') }}"
                       class="btn btn-dark btn-sm">
                        <i class="fas fa-fw fa-plus"></i> Permission
                    </a>
                </p>
            @endcan
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#permissions').DataTable({
                ajax: '{{ route('admin.permissions.index') }}',
                columns: [
                    {data: 'group'},
                    {data: 'display_name'},
                    {data: 'name'},
                ]
            });

            $('#roles').DataTable({
                searching: false,
                bInfo: false,
                ajax: '{{ route('admin.roles.index') }}',
                columns: [
                    {data: 'name'}
                ],
                fnDrawCallback: function (settings) {
                    $(settings.nTHead).hide();
                }
            });
        });
    </script>
@endpush
