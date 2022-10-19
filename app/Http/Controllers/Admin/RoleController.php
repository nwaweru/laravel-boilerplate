<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermissionGroup;
use App\Traits\Utilities;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    use Utilities;

    /**
     * Display a listing of the resource.
     *
     * @return View
     *
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('roles.index');

        if (request()->ajax()) {
            return DataTables::of(Role::query())
                ->addColumn('name', function ($role) {
                    if (Auth::user()->can('roles.show')) {
                        return '<a class="text-decoration-none" href="'.route('admin.roles.show', ['role' => $role->uuid]).'">'.$role->name.'</a>';
                    }

                    return $role->name;
                })
                ->rawColumns(['name'])
                ->toJson();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     *
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('roles.create');

        return view('admin.roles.create', [
            'permissionGroups' => PermissionGroup::orderBy('name', 'asc')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response|RedirectResponse
     *
     * @throws AuthorizationException
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

            return redirect()->route('admin.roles.show', ['role' => $role->uuid]);
        } catch (Exception $ex) {
            Log::error($ex);

            return redirect()->back()->withInput()->with([
                'alert' => (object) [
                    'type' => 'danger',
                    'text' => 'Database Error',
                ],
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $uuid
     * @return View
     *
     * @throws AuthorizationException
     */
    public function show($uuid)
    {
        $this->authorize('roles.show');

        $role = Role::where('uuid', $uuid)->firstOrFail();

        return view('admin.roles.show', [
            'role' => $role,
            'permissionGroups' => PermissionGroup::orderBy('name', 'asc')->get(),
            'currentPermissions' => $role->permissions()->pluck('id')->toArray(),
            'userRoles' => $this->getUserRoles(Auth::user()),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $uuid
     * @return View
     *
     * @throws AuthorizationException
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
     * @param  Request  $request
     * @param  string  $uuid
     * @return Response|RedirectResponse
     *
     * @throws AuthorizationException
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

            return redirect()->route('admin.roles.show', ['role' => $role->uuid])->with([
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
                    'text' => 'Database Error',
                ],
            ]);
        }
    }

    /**
     * Display the specified resource selected for deletion.
     *
     * @param  string  $uuid
     * @return View|RedirectResponse
     *
     * @throws AuthorizationException
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
     * @param  string  $uuid
     * @return Response|RedirectResponse
     *
     * @throws AuthorizationException
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
                    'text' => 'Database Error',
                ],
            ]);
        }
    }
}
