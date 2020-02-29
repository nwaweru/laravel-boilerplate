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

class RoleController extends Controller
{
    use Utilities;

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $this->authorize('roles.index');

        if (request()->ajax()) {
            $roles = Role::query();

            return DataTables::of($roles)
                ->addColumn('name', function ($role) {
                    if (Auth::user()->can('roles.show')) {
                        return '<a class="card-link" href="' . route('admin.roles.show', ['role' => $role->uuid]) . '">' . $role->name . '</a>';
                    }

                    return $role->name;
                })
                ->addColumn('actions', function ($role) {
                    $actions = '';

                    if (Auth::user()->can('roles.delete') && !in_array($role->name, $this->getUserRoles(Auth::user()))) {
                        $actions .= '<a class="card-link" href="' . route('admin.roles.delete', ['role' => $role->uuid]) . '"><i title="Delete" class="text-danger fas fa-fw fa-trash-alt"></i></a>';
                    }

                    if (Auth::user()->can('roles.edit')) {
                        $actions .= '<a class="card-link" href="' . route('admin.roles.edit', ['role' => $role->uuid]) . '"><i title="Edit" class="fas fa-fw fa-edit"></i></a>';
                    }


                    return $actions;
                })
                ->rawColumns(['name', 'actions'])
                ->toJson();
        }

        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $this->authorize('roles.create');

        $permissionGroups = PermissionGroup::orderBy('name', 'asc')->get();

        return view('admin.roles.create', [
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
        $this->authorize('roles.create');

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'permissions' => ['required', 'exists:permissions,id'],
        ]);

        try {
            $role = Role::create([
                'uuid' => $this->generateUuid(),
                'name' => $request->name,
            ]);

            $role->givePermissionTo(Permission::whereIn('id', $request->permissions)->pluck('name'));

            return redirect()->route('admin.roles.index')->with([
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
        $this->authorize('roles.show');

        $role = Role::where('uuid', $uuid)->firstOrFail();
        $permissionGroups = PermissionGroup::orderBy('name', 'asc')->get();
        $currentPermissions = $role->permissions()->pluck('id')->toArray();

        return view('admin.roles.show', [
            'role' => $role,
            'permissionGroups' => $permissionGroups,
            'currentPermissions' => $currentPermissions,
            'userRoles' => $this->getUserRoles(Auth::user()),
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
        $this->authorize('roles.edit');

        $role = Role::where('uuid', $uuid)->firstOrFail();
        $permissionGroups = PermissionGroup::orderBy('name', 'asc')->get();
        $currentPermissions = $role->permissions()->pluck('id')->toArray();

        return view('admin.roles.edit', [
            'role' => $role,
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
        $this->authorize('roles.edit');

        $role = role::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($role->id)],
            'permissions' => ['required', 'exists:permissions,id'],
        ]);

        try {
            $role->update([
                'name' => $request->name,
            ]);

            $role->syncPermissions(Permission::whereIn('id', $request->permissions)->pluck('name'));

            return redirect()->route('admin.roles.edit', ['role' => $role->uuid])->with([
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
        $this->authorize('roles.delete');

        $role = Role::where('uuid', $uuid)->firstOrFail();

        if (in_array($role->name, $this->getUserRoles(Auth::user()))) {
            return redirect()->route('admin.roles.index')->with([
                'alert' => (object) [
                    'type' => 'danger',
                    'text' => 'Permission Denied',
                ],
            ]);
        }

        $permissionGroups = PermissionGroup::orderBy('name', 'asc')->get();
        $currentPermissions = $role->permissions()->pluck('id')->toArray();

        return view('admin.roles.delete', [
            'role' => $role,
            'permissionGroups' => $permissionGroups,
            'currentPermissions' => $currentPermissions,
            'userRoles' => $this->getUserRoles(Auth::user()),
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
        $this->authorize('roles.delete');

        $role = Role::where('uuid', $uuid)->firstOrFail();

        if (in_array($role->name, $this->getUserRoles(Auth::user()))) {
            return redirect()->route('admin.roles.index')->with([
                'alert' => (object) [
                    'type' => 'danger',
                    'text' => 'Permission Denied',
                ],
            ]);
        }

        try {
            $role->delete();

            return redirect()->route('admin.roles.index')->with([
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
