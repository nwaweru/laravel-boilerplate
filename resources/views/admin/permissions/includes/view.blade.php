<div class="table-responsive">
    <table class="table table-borderless">
        <tr>
            <td class="text-right">Group:</td>
            <td><b>{{ $permission->permissionGroup->name }}</b></td>
        </tr>
        <tr>
            <td class="text-right">Permission:</td>
            <td>
                <b>
                    @if(Auth::user()->can('permissions.show'))
                        <a href="{{ route('admin.permissions.show', ['permission' => $permission->uuid]) }}" class="text-decoration-none">{{ $permission->display_name }}</a>
                    @else
                        {{ $permission->display_name }}
                    @endif
                </b>
            </td>
        </tr>
        <tr>
            <td class="text-right">Route:</td>
            <td><b>{{ $permission->name }}</b></td>
        </tr>
    </table>
</div>
