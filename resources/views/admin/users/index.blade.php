@extends('ui.layouts.app', ['title' => 'Users'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="clearfix">
                        <h1 class="float-left">Users</h1>
                        <a href="{{ route('admin.users.create') }}" class="float-right btn btn-primary btn-sm">
                            <i class="fas fa-fw fa-plus"></i> User
                        </a>
                    </div>
                    <table id="users" class="table table-hover dt-responsive nowrap">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Email</th>
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
                ajax: '{{ route('admin.users.index') }}',
                columns: [
                    {data: 'first_name', name: 'first_name'},
                    {data: 'last_name', name: 'last_name'},
                    {data: 'email', name: 'email'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false}
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).find('td:eq(3)').attr('class', 'text-right');
                }
            });
        });
    </script>
@endpush
