@extends('ui.layouts.basic', ['title' => 'Delete User'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h3 class="text-danger">Delete User?</h3>
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <td class="text-right">First Name:</td>
                            <td><b>{{ $user->first_name }}</b></td>
                        </tr>
                        <tr>
                            <td class="text-right">Lasy Name:</td>
                            <td><b>{{ $user->last_name }}</b></td>
                        </tr>
                        <tr>
                            <td class="text-right">Email:</td>
                            <td><b>{{ $user->email }}</b></td>
                        </tr>
                    </table>
                </div>
                <form class="pt-3" method="POST" action="{{ route('admin.users.destroy', ['user' => $user->uuid]) }}" novalidate>
                    @method('DELETE')
                    @csrf
                    <div class="form-group mt-3">
                        <p class="text-danger text-center">
                            <i class="fas fa-info-circle fa-fw"></i>
                            Cannot be Undone
                            <i class="fas fa-info-circle fa-fw"></i>
                        </p>
                        <button type="submit"
                                class="btn btn-block btn-danger auth-form-btn">
                            Delete User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
