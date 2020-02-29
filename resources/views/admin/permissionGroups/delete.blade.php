@extends('ui.layouts.basic', ['title' => 'Delete User'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h3 class="text-danger">Delete User?</h3>

                @include('admin.users.includes.profile')
                
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
