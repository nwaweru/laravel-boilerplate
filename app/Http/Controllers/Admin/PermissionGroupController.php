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
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class PermissionGroupController extends Controller
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
            $permissionGroups = PermissionGroup::query();

            return DataTables::of($permissionGroups)
                ->addColumn('name', function ($permissionGroup) {
                    if (Auth::user()->can('permissions.show')) {
                        return '<a class="card-link" href="' . route('admin.permissionGroups.show', ['permissionGroup' => $permissionGroup->uuid]) . '">' . $permissionGroup->name . '</a>';
                    }

                    return $permissionGroup->name;
                })
                ->addColumn('actions', function ($permissionGroup) {
                    $actions = '';

                    if (Auth::user()->can('permissions.delete') && !in_array($permissionGroup->id, $this->getUserPermissionGroups(Auth::user()))) {
                        $actions .= '<a class="card-link" href="' . route('admin.permissionGroups.delete', ['permissionGroup' => $permissionGroup->uuid]) . '"><i title="Delete" class="text-danger fas fa-fw fa-trash-alt"></i></a>';
                    }

                    if (Auth::user()->can('permissions.edit')) {
                        $actions .= '<a class="card-link" href="' . route('admin.permissionGroups.edit', ['permissionGroup' => $permissionGroup->uuid]) . '"><i title="Edit" class="fas fa-fw fa-edit"></i></a>';
                    }

                    return $actions;
                })
                ->rawColumns(['name', 'actions'])
                ->toJson();
        }

        return view('admin.permissionGroups.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $this->authorize('permissions.create');

        $permissionGroupGroups = PermissionGroupGroup::orderBy('name', 'asc')->get();

        return view('admin.permissions.create', [
            'PermissionGroupGroups' => $permissionGroupGroups,
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
            'PermissionGroup_group' => ['required', 'exists:PermissionGroup_groups,id'],
            'name' => ['required', 'string', 'max:255', 'unique:PermissionGroups,name'],
            'display_name' => ['required', 'string', 'max:255', 'unique:PermissionGroups,name'],
        ]);

        try {
            PermissionGroup::create([
                'PermissionGroup_group_id' => $request->PermissionGroup_group,
                'uuid' => $this->generateUuid(),
                'name' => $request->name,
                'display_name' => $request->display_name,
            ]);

            return redirect()->route('admin.permissionGroups.index')->with([
                'alert' => (object) [
                    'type' => 'success',
                    'text' => 'PermissionGroup Created',
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
            'PermissionGroup' => MyPermissionGroup::where('uuid', $uuid)->firstOrFail(),
            'userPermissionGroups' => $this->getUserPermissionGroups(Auth::user()),
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
            'PermissionGroup' => MyPermissionGroup::where('uuid', $uuid)->firstOrFail(),
            'PermissionGroupGroups' => PermissionGroupGroup::orderBy('name', 'asc')->get(),
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

        $permissionGroup = PermissionGroup::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'PermissionGroup_group' => ['required', 'exists:PermissionGroup_groups,id'],
            'name' => ['required', 'string', 'max:255', Rule::unique('PermissionGroups')->ignore($permissionGroup->id)],
            'display_name' => ['required', 'string', 'max:255', Rule::unique('PermissionGroups')->ignore($permissionGroup->id)],
        ]);

        try {
            $permissionGroup->update([
                'PermissionGroup_group_id' => $request->PermissionGroup_group,
                'name' => $request->name,
                'display_name' => $request->display_name,
            ]);

            return redirect()->route('admin.permissionGroups.show', ['permissionGroup' => $permissionGroup->uuid])->with([
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

        $permissionGroup = MyPermissionGroup::where('uuid', $uuid)->firstOrFail();

        if (in_array($permissionGroup->name, $this->getUserPermissionGroups(Auth::user()))) {
            return redirect()->route('admin.permissionGroups.index')->with([
                'alert' => (object) [
                    'type' => 'danger',
                    'text' => 'PermissionGroup Denied',
                ],
            ]);
        }

        return view('admin.permissions.delete', [
            'PermissionGroup' => $permissionGroup,
            'userPermissionGroups' => $this->getUserPermissionGroups(Auth::user()),
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

        $permissionGroup = PermissionGroup::where('uuid', $uuid)->firstOrFail();

        if (in_array($permissionGroup->name, $this->getUserPermissionGroups(Auth::user()))) {
            return redirect()->route('admin.permissionGroups.index')->with([
                'alert' => (object) [
                    'type' => 'danger',
                    'text' => 'PermissionGroup Denied',
                ],
            ]);
        }

        try {
            $permissionGroup->delete();

            return redirect()->route('admin.permissionGroups.index')->with([
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
