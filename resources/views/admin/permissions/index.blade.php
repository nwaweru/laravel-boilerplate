@extends('ui.layouts.app', ['title' => 'Permissions'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="clearfix">
                        <h1 class="float-left">Permissions</h1>
                        @canany(['permissions.create', 'permissionGroups.create'])
                            <div class="float-right">
                                @can('permissions.create')
                                    <a href="{{ route('admin.permissions.create') }}"
                                       class="btn btn-primary btn-sm mx-2">
                                        <i class="fas fa-fw fa-plus"></i> Permission
                                    </a>
                                @endcan
                            </div>
                        @endcanany
                    </div>
                    <table id="permissions" class="table table-hover table-borderless dt-responsive nowrap">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Permission Group</th>
                            <th scope="col">Display Name</th>
                            <th scope="col">Name</th>
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
                ajax: '{{ route('admin.permissions.index') }}',
                columns: [
                    {data: 'group'},
                    {data: 'display_name'},
                    {data: 'name'},
                ]
            });
        });
    </script>
@endpush
