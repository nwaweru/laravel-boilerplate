@extends('ui.layouts.app', ['title' => 'Setup'])

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Users</h4>
                    <hr>
                    <table id="users" class="table table-hover dt-responsive nowrap">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
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
            $('#users').DataTable({
                responsive: true,
                paging: false,
                scrollY: '40vh',
                scrollCollapse: true,
                ajax: '{{ route('users.index') }}',
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'roles', name: 'roles'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false}
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).find('td:eq(3)').attr('class', 'text-right');
                }
            });
        });
    </script>
@endpush
