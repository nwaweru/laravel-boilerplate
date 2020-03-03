@extends('users.show', ['title' => $user->first_name . ' ' . $user->last_name . ' - ' . config('app.name')])

@section('action')
    <form class="pb-4 bg-white" method="POST" action="{{ route('users.destroy', ['user' => $user->uuid]) }}" novalidate>
        @method('DELETE')
        @csrf
        <div class="text-center">
            <p class="text-danger">
                <i class="fas fa-info-circle fa-fw"></i>
                Cannot be Undone
                <i class="fas fa-info-circle fa-fw"></i>
            </p>
            <button type="submit" class="btn btn-danger">
                Delete Account
            </button>
        </div>
    </form>
@endsection
