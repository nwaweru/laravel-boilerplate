@extends('ui.layouts.basic', ['title' => 'Delete Permission'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h3 class="text-danger">Delete Permission?</h3>
                
                @include('admin.permissions.includes.view')

                @if (Auth::user()->can('permissions.delete') && !in_array($permission->name, $userPermissions))
                    <form class="pt-3" method="POST" action="{{ route('admin.permissions.destroy', ['permission' => $permission->uuid]) }}" novalidate>
                        @method('DELETE')
                        @csrf
                        <p class="text-danger text-center">
                            <i class="fas fa-info-circle fa-fw"></i>
                            Cannot be Undone
                            <i class="fas fa-info-circle fa-fw"></i>
                        </p>
                        <div class="form-group mt-3 mb-0">
                            <button type="submit"
                                    class="btn btn-block btn-danger">
                                Delete Permission
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
