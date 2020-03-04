<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-borderless">
                <tr>
                    <td class="text-right">Name:</td>
                    <td><b>{{ $role->name }}</b></td>
                </tr>
                <tr>
                    <td class="text-right">Permissions:</td>
                    <td><b>{{ $role->permissions->count() }}</b></td>
                </tr>
                <tr>
                    <td class="text-right">Users:</td>
                    <td><b>{{ $role->users->count() }}</b></td>
                </tr>
            </table>
        </div>
    </div>
</div>
