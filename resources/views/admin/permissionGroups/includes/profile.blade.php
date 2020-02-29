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
        @if ($user->role)
        <tr>
            <td class="text-right">Role:</td>
            <td><b>{{ $user->role }}</b></td>
        </tr>
        @endif
    </table>
</div>
