<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermissionGroup;
use App\Traits\Utilities;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
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
            $permissions = Permission::query();

            return DataTables::of($permissions)
                ->addColumn('name', function (Permission $permission) {
                    if (Auth::user()->can('permissions.show')) {
                        return '<a class="card-link" href="' . route('admin.permissions.show', ['permission' => $permission->uuid]) . '">' . $permission->name . '</a>';
                    }

                    return $permission->name;
                })
                ->addColumn('actions', function (Permission $permission) {
                    $actions = '';

                    if (Auth::user()->can('permissions.delete') && !in_array($permission->name, $this->getUserPermissions(Auth::user()))) {
                        $actions .= '<a class="card-link" href="' . route('admin.permissions.delete', ['permission' => $permission->uuid]) . '"><i title="Delete" class="text-danger fas fa-fw fa-trash-alt"></i></a>';
                    }

                    if (Auth::user()->can('permissions.edit')) {
                        $actions .= '<a class="card-link" href="' . route('admin.permissions.edit', ['permission' => $permission->uuid]) . '"><i title="Edit" class="fas fa-fw fa-edit"></i></a>';
                    }

                    return $actions;
                })
                ->rawColumns(['name', 'actions'])
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
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name'],
            'permissions' => ['required', 'exists:permissions,id'],
        ]);

        try {
            $permission = Role::create([
                'uuid' => $this->generateUuid(),
                'name' => $request->name,
            ]);

            $permission->givePermissionTo(Permission::whereIn('id', $request->permissions)->pluck('name'));

            return redirect()->route('admin.permissions.index')->with([
                'alert' => (object) [
                    'type' => 'success',
                    'text' => 'Role Created',
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

        $permission = Role::where('uuid', $uuid)->firstOrFail();
        $permissionGroups = PermissionGroup::orderBy('name', 'asc')->get();
        $currentPermissions = $permission->permissions()->pluck('id')->toArray();

        return view('admin.permissions.show', [
            'role' => $permission,
            'permissionGroups' => $permissionGroups,
            'currentPermissions' => $currentPermissions,
            'userpermissions' => $this->getUserpermissions(Auth::user()),
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

        $permission = Role::where('uuid', $uuid)->firstOrFail();
        $permissionGroups = PermissionGroup::orderBy('name', 'asc')->get();
        $currentPermissions = $permission->permissions()->pluck('id')->toArray();

        return view('admin.permissions.edit', [
            'role' => $permission,
            'permissionGroups' => $permissionGroups,
            'currentPermissions' => $currentPermissions,
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

        $permission = role::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions')->ignore($permission->id)],
            'permissions' => ['required', 'exists:permissions,id'],
        ]);

        try {
            $permission->update([
                'name' => $request->name,
            ]);

            $permission->syncPermissions(Permission::whereIn('id', $request->permissions)->pluck('name'));

            return redirect()->route('admin.permissions.show', ['role' => $permission->uuid])->with([
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

        $permission = Role::where('uuid', $uuid)->firstOrFail();

        if (in_array($permission->name, $this->getUserpermissions(Auth::user()))) {
            return redirect()->route('admin.permissions.index')->with([
                'alert' => (object) [
                    'type' => 'danger',
                    'text' => 'Permission Denied',
                ],
            ]);
        }

        $permissionGroups = PermissionGroup::orderBy('name', 'asc')->get();
        $currentPermissions = $permission->permissions()->pluck('id')->toArray();

        return view('admin.permissions.delete', [
            'role' => $permission,
            'permissionGroups' => $permissionGroups,
            'currentPermissions' => $currentPermissions,
            'userpermissions' => $this->getUserpermissions(Auth::user()),
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

        $permission = Role::where('uuid', $uuid)->firstOrFail();

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
