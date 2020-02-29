<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission as MyPermission;
use App\Models\PermissionGroup;
use App\Traits\Utilities;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    use Utilities;

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $this->authorize('permissions.index');

        if (request()->ajax()) {
            $permissions = MyPermission::with('permissionGroup')->get();

            return DataTables::of($permissions)
                ->addColumn('name', function ($permission) {
                    if (Auth::user()->can('permissions.show')) {
                        return '<a class="card-link" href="' . route('admin.permissions.show', ['permission' => $permission->uuid]) . '">' . $permission->name . '</a>';
                    }

                    return $permission->name;
                })
                ->addColumn('group', function ($permission) {
                    if (Auth::user()->can('permissionGroups.show')) {
                        return '<a class="card-link" href="' . route('admin.permissionGroups.show', ['permissionGroup' => $permission->permissionGroup->uuid]) . '">' . $permission->permissionGroup->name . '</a>';
                    }

                    return $permission->permissionGroup->name;
                })
                ->addColumn('actions', function ($permission) {
                    $actions = '';

                    if (Auth::user()->can('permissions.delete') && !in_array($permission->name, $this->getUserPermissions(Auth::user()))) {
                        $actions .= '<a class="card-link" href="' . route('admin.permissions.delete', ['permission' => $permission->uuid]) . '"><i title="Delete" class="text-danger fas fa-fw fa-trash-alt"></i></a>';
                    }

                    if (Auth::user()->can('permissions.edit')) {
                        $actions .= '<a class="card-link" href="' . route('admin.permissions.edit', ['permission' => $permission->uuid]) . '"><i title="Edit" class="fas fa-fw fa-edit"></i></a>';
                    }

                    return $actions;
                })
                ->rawColumns(['name', 'group', 'actions'])
                ->toJson();
        }

        return view('admin.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $this->authorize('permissions.create');

        $permissionGroups = PermissionGroup::orderBy('name', 'asc')->get();

        return view('admin.permissions.create', [
            'permissionGroups' => $permissionGroups,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->authorize('permissions.create');

        $request->validate([
            'permission_group' => ['required', 'exists:permission_groups,id'],
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name'],
            'display_name' => ['required', 'string', 'max:255', 'unique:permissions,name'],
        ]);

        try {
            Permission::create([
                'permission_group_id' => $request->permission_group,
                'uuid' => $this->generateUuid(),
                'name' => $request->name,
                'display_name' => $request->display_name,
            ]);

            return redirect()->route('admin.permissions.index')->with([
                'alert' => (object) [
                    'type' => 'success',
                    'text' => 'Permission Created',
                ],
            ]);
        } catch (Exception $ex) {
            Log::error($ex);

            return redirect()->back()->withInput()->with([
                'alert' => (object) [
                    'type' => 'danger',
                    'text' => 'Database Error Occurred',
                ],
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param uuid $uuid
     * @return View
     */
    public function show($uuid)
    {
        $this->authorize('permissions.show');

        return view('admin.permissions.show', [
            'permission' => MyPermission::where('uuid', $uuid)->firstOrFail(),
            'userPermissions' => $this->getUserPermissions(Auth::user()),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param uuid $uuid
     * @return View
     */
    public function edit($uuid)
    {
        $this->authorize('permissions.edit');

        return view('admin.permissions.edit', [
            'permission' => MyPermission::where('uuid', $uuid)->firstOrFail(),
            'permissionGroups' => PermissionGroup::orderBy('name', 'asc')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param uuid $uuid
     * @return Response
     */
    public function update(Request $request, $uuid)
    {
        $this->authorize('permissions.edit');

        $permission = Permission::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'permission_group' => ['required', 'exists:permission_groups,id'],
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions')->ignore($permission->id)],
            'display_name' => ['required', 'string', 'max:255', Rule::unique('permissions')->ignore($permission->id)],
        ]);

        try {
            $permission->update([
                'permission_group_id' => $request->permission_group,
                'name' => $request->name,
                'display_name' => $request->display_name,
            ]);

            return redirect()->route('admin.permissions.show', ['permission' => $permission->uuid])->with([
                'alert' => (object) [
                    'type' => 'success',
                    'text' => 'Changes Saved',
                ],
            ]);
        } catch (Exception $ex) {
            Log::error($ex);

            return redirect()->back()->withInput()->with([
                'alert' => (object) [
                    'type' => 'danger',
                    'text' => 'Database Error Occurred',
                ],
            ]);
        }
    }

    /**
     * Display the specified resource selected for deletion.
     *
     * @param uuid $uuid
     * @return View
     */
    public function delete($uuid)
    {
        $this->authorize('permissions.delete');

        $permission = MyPermission::where('uuid', $uuid)->firstOrFail();

        if (in_array($permission->name, $this->getUserPermissions(Auth::user()))) {
            return redirect()->route('admin.permissions.index')->with([
                'alert' => (object) [
                    'type' => 'danger',
                    'text' => 'Permission Denied',
                ],
            ]);
        }

        return view('admin.permissions.delete', [
            'permission' => $permission,
            'userPermissions' => $this->getUserPermissions(Auth::user()),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param uuid $uuid
     * @return Response
     */
    public function destroy($uuid)
    {
        $this->authorize('permissions.delete');

        $permission = Permission::where('uuid', $uuid)->firstOrFail();

        if (in_array($permission->name, $this->getUserpermissions(Auth::user()))) {
            return redirect()->route('admin.permissions.index')->with([
                'alert' => (object) [
                    'type' => 'danger',
                    'text' => 'Permission Denied',
                ],
            ]);
        }

        try {
            $permission->delete();

            return redirect()->route('admin.permissions.index')->with([
                'alert' => (object) [
                    'type' => 'success',
                    'text' => 'Role Deleted',
                ],
            ]);
        } catch (Exception $ex) {
            Log::error($ex);

            return redirect()->back()->with([
                'alert' => (object) [
                    'type' => 'danger',
                    'text' => 'Database Error Occurred',
                ],
            ]);
        }
    }
}
