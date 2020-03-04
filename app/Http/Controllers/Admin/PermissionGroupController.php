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
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class PermissionGroupController extends Controller
{
    use Utilities;

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('permissionGroups.create');

        return view('admin.permissionGroups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response|RedirectResponse
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('permissionGroups.create');

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permission_groups,name'],
        ]);


        $this->clearEmptyPermissionGroups();

        try {
            $permissionGroup = PermissionGroup::create([
                'uuid' => $this->generateUuid(),
                'name' => $request->name,
            ]);

            return redirect()->route('admin.permissions.create', ['permissionGroup' => $permissionGroup->uuid]);
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
     * Show the form for editing the specified resource.
     *
     * @param string $uuid
     * @param Request $request
     * @return View
     * @throws AuthorizationException
     */
    public function edit($uuid, Request $request)
    {
        $this->authorize('permissionGroups.edit');

        // A permission is needed for the redirect after update.
        (is_null($request->query('permission'))) && abort(404);

        return view('admin.permissionGroups.edit', [
            'permissionGroup' => PermissionGroup::where('uuid', $uuid)->firstOrFail(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string $uuid
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, $uuid)
    {
        $this->authorize('permissionGroups.edit');

        $permissionGroup = PermissionGroup::where('uuid', $uuid)->firstOrFail();

        // A permission is needed for the redirect after update.
        (is_null($request->query('permission'))) && abort(404);

        $permission = Permission::where('uuid', $request->query('permission'))->firstOrFail();

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('permission_groups')->ignore($permissionGroup->id)],
        ]);

        $this->clearEmptyPermissionGroups($permissionGroup->uuid);

        try {
            $permissionGroup->update([
                'name' => $request->name,
            ]);

            return redirect()->route('admin.permissions.edit', ['permission' => $permission->uuid]);
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
     * Clear empty permission groups BUT the excluded one.
     *
     * @return void
     * @throws AuthorizationException
     */
    private function clearEmptyPermissionGroups($excluded = null)
    {
        if (!Auth::user()->can('permissionGroups.create') || !Auth::user()->can('permissionGroups.edit')) {
            abort(403);
        }

        $permissionGroups = PermissionGroup::all();

        foreach ($permissionGroups as $group) {
            if ($group->permissions->count() < 1 && !is_null($excluded) && $excluded !== $group->uuid) {
                try {
                    $group->delete();
                } catch (Exception $ex) {
                    Log::error($ex);
                }
            }
        }
    }
}
