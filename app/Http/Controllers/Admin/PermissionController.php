<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission as MyPermission;
use App\Models\PermissionGroup;
use App\Traits\Utilities;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
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
        $this->authorize('permissions.index');

        if (request()->ajax()) {
            return DataTables::of(MyPermission::with('permissionGroup')->get())
                ->addColumn('group', function ($permission) {
                    return $permission->permissionGroup->name;
                })
                ->addColumn('display_name', function ($permission) {
                    if (Auth::user()->can('permissions.show')) {
                        return '<a class="text-decoration-none" href="'.route('admin.permissions.show', ['permission' => $permission->uuid]).'">'.$permission->display_name.'</a>';
                    }

                    return $permission->display_name;
                })
                ->rawColumns(['display_name'])
                ->toJson();
        }

        return view('admin.permissions.index');
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
        $this->authorize('permissions.create');

        $permissionGroups = PermissionGroup::orderBy('name', 'asc')->get();

        return view('admin.permissions.create', [
            'permissionGroups' => $permissionGroups,
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
        $this->authorize('permissions.create');

        $request->validate([
            'permission_group' => ['required', 'exists:permission_groups,id'],
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name'],
            'display_name' => ['required', 'string', 'max:255'],
        ]);

        try {
            $permission = Permission::create([
                'permission_group_id' => $request->permission_group,
                'uuid' => $this->generateUuid(),
                'name' => $request->name,
                'display_name' => $request->display_name,
            ]);

            return redirect()->route('admin.permissions.show', ['permission' => $permission->uuid]);
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
        $this->authorize('permissions.show');

        return view('admin.permissions.show', [
            'permission' => MyPermission::where('uuid', $uuid)->firstOrFail(),
            'userPermissions' => $this->getUserPermissions(Auth::user()),
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
        $this->authorize('permissions.edit');

        return view('admin.permissions.edit', [
            'permission' => MyPermission::where('uuid', $uuid)->firstOrFail(),
            'permissionGroups' => PermissionGroup::orderBy('name', 'asc')->get(),
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

            return redirect()->route('admin.permissions.show', ['permission' => $permission->uuid]);
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
        $this->authorize('permissions.delete');

        $permission = MyPermission::where('uuid', $uuid)->firstOrFail();

        (in_array($permission->name, $this->getUserPermissions(Auth::user()))) && abort(403);

        return view('admin.permissions.delete', [
            'permission' => $permission,
            'userPermissions' => $this->getUserPermissions(Auth::user()),
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
        $this->authorize('permissions.delete');

        $permission = MyPermission::where('uuid', $uuid)->firstOrFail();

        (in_array($permission->name, $this->getUserPermissions(Auth::user()))) && abort(403);

        try {
            $permissionGroup = PermissionGroup::find($permission->permissionGroup->id);

            // Delete the permission group if this is the last permission associated with it.
            if ($permissionGroup->permissions->count() <= 1) {
                $permissionGroup->delete();
            }

            $permission->delete();

            Artisan::call('cache:forget spatie.permission.cache');
            Artisan::call('cache:clear');

            return redirect()->route('admin.permissions.index')->with([
                'alert' => (object) [
                    'type' => 'success',
                    'text' => 'Permission Deleted',
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
