@extends('ui.layouts.app', ['title' => 'Users'])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="clearfix">
                        <h1 class="float-left">Users</h1>
                        <a href="{{ route('users.create') }}" class="float-right btn btn-primary btn-sm">
                            <i class="fas fa-fw fa-plus"></i> User
                        </a>
                    </div>
                    <table id="users" class="table table-borderless table-hover dt-responsive nowrap"></table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#users').DataTable({
                ajax: "{{ route('users.index') }}",
                columns: [
                    {data: 'name'},
                    {data: 'email'}
                ],
                fnDrawCallback: function (settings) {
                    $(settings.nTHead).hide();
                }
            });
        });
    </script>
@endpush
