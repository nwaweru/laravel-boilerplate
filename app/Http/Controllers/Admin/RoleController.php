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
                ->addColumn('roles', function (role $role) {
                    return implode(', ', $role->pluck('name')->toArray());
                })
                ->addColumn('actions', function (role $role) {
                    $actions = '';

                    if (Auth::user()->can('roles.delete') && $role->name !== 'super-user') {
                        $actions .= '<a class="card-link" href="' . route('admin.roles.delete', ['role' => $role->uuid]) . '"><i title="Delete" class="text-danger fas fa-fw fa-trash-alt"></i></a>';
                    }

                    if (Auth::user()->can('roles.edit')) {
                        $actions .= '<a class="card-link" href="' . route('admin.roles.edit', ['role' => $role->uuid]) . '"><i title="Edit" class="fas fa-fw fa-edit"></i></a>';
                    }

                    if (Auth::user()->can('roles.show')) {
                        $actions .= '<a class="card-link" href="' . route('admin.roles.show', ['role' => $role->uuid]) . '"><i title="View" class="fas fa-fw fa-info-circle"></i></a>';
                    }

                    return $actions;
                })
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
            'name' => ['required', 'unique:roles,name'],
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
        if (Auth::role()->uuid !== $uuid) {
            $this->authorize('roles.read');
        }

        $role = role::where('uuid', $uuid)->firstOrFail();

        return view('roles.show', [
            'role' => $role,
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
        if (Auth::role()->uuid !== $uuid) {
            $this->authorize('roles.update');
        }

        $role = role::where('uuid', $uuid)->firstOrFail();
        $roles = Role::all();
        $currentRoles = $role->roles()->pluck('id')->toArray();

        return view('roles.edit', [
            'role' => $role,
            'roles' => $roles,
            'currentRoles' => $currentRoles,
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
        if (Auth::role()->uuid !== $uuid) {
            $this->authorize('roles.update');
        }

        $role = role::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'string', 'email', 'max:255', Rule::unique('roles')->ignore($role)],
            'roles' => ['sometimes', 'required', 'exists:roles,id'],
        ]);

        try {
            $role->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => (!is_null($request->email)) ? $request->email : $role->email,
            ]);

            if (!is_null($request->roles)) {
                $roles = Role::whereIn('id', $request->roles)->pluck('name')->toArray();
                $role->syncRoles($roles);
            }

            return redirect()->route('roles.show', ['role' => $role->uuid])->with([
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
                    'text' => 'Internal Error Occurred',
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

        $role = role::where('uuid', $uuid)->firstOrFail();

        return view('roles.delete', [
            'role' => $role,
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

        $role = role::where('uuid', $uuid)->firstOrFail();

        try {
            $role->delete();

            return redirect()->route('roles.index')->with([
                'alert' => (object) [
                    'type' => 'success',
                    'text' => 'role Deleted',
                ],
            ]);
        } catch (Exception $ex) {
            Log::error($ex);

            return redirect()->back()->withInput()->with([
                'alert' => (object) [
                    'type' => 'danger',
                    'text' => 'Internal Error Occurred',
                ],
            ]);
        }
    }
}
