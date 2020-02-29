@extends('ui.layouts.app', ['title' => 'Permissions'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="clearfix">
                        <h1 class="float-left">Permissions</h1>
                        <a href="{{ route('admin.permissions.create') }}" class="float-right btn btn-primary btn-sm">
                            <i class="fas fa-fw fa-plus"></i> Permission
                        </a>
                    </div>
                    <table id="permissions" class="table table-hover table-borderless dt-responsive nowrap">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Display Name</th>
                            <th scope="col">Route</th>
                            <th scope="col">Permission Group</th>
                            <th scope="col">&nbsp;</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#permissions').DataTable({
                responsive: true,
                paging: false,
                scrollY: '40vh',
                scrollCollapse: true,
                ajax: '{{ route('admin.permissions.index') }}',
                columns: [
                    {data: 'display_name', name: 'display_name'},
                    {data: 'name', name: 'name'},
                    {data: 'group', name: 'group'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false}
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).find('td:eq(3)').attr('class', 'text-right');
                }
            });
        });
    </script>
@endpush
