<div class="table-responsive">
    <table class="table table-borderless">
        <tr>
            <td class="text-right">Permission Group:</td>
            <td><b>{{ $permission->permissionGroup->name }}</b></td>
        </tr>
        <tr>
            <td class="text-right">Display Name:</td>
            <td><b>{{ $permission->display_name }}</b></td>
        </tr>
        <tr>
            <td class="text-right">Route:</td>
            <td><b>{{ $permission->name }}</b></td>
        </tr>
    </table>
</div>
