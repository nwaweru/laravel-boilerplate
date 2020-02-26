@extends('ui.layouts.app', ['title' => 'Setup'])

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Users</h4>
                    <hr>
                    <table id="datatable" class="table table-hover">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>Role</td>
                                <td class="text-right">
                                    <a href="#"><i class="fas fa-fw fa-trash text-danger" title="Delete"></i></a>
                                    <a href="#"><i class="fas fa-fw fa-edit mx-3" title="Edit"></i></a>
                                    <a href="#"><i class="fas fa-fw fa-eye" title="View"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
