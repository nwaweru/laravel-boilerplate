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
                    <table id="roles" class="table table-hover dt-responsive nowrap">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Display Name</th>
                            <th scope="col">Name</th>
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
            $('#roles').DataTable({
                responsive: true,
                paging: false,
                scrollY: '40vh',
                scrollCollapse: true,
                ajax: '{{ route('admin.roles.index') }}',
                columns: [
                    {data: 'display_name', name: 'display_name'},
                    {data: 'name', name: 'name'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false}
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).find('td:eq(2)').attr('class', 'text-right');
                }
            });
        });
    </script>
@endpush
