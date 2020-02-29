@extends('ui.layouts.app', ['title' => 'Permission Groups'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="clearfix">
                        <h1 class="float-left">Permission Groups</h1>
                        <a href="{{ route('admin.permissionGroups.create') }}" class="float-right btn btn-primary btn-sm">
                            <i class="fas fa-fw fa-plus"></i> Permission Group
                        </a>
                    </div>
                    <table id="permissionGroups" class="table table-borderless table-hover dt-responsive nowrap">

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#permissionGroups').DataTable({
                responsive: true,
                paging: false,
                scrollY: '40vh',
                scrollCollapse: true,
                ajax: '{{ route('admin.permissionGroups.index') }}',
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false}
                ],
                createdRow: function (row, data, dataIndex) {
                    $(row).find('td:eq(1)').attr('class', 'text-right');
                },
                fnDrawCallback: function (settings) {
                    $(settings.nTHead).hide();
                }
            });
        });
    </script>
@endpush
