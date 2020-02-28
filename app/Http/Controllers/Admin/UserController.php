<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\WelcomeToken;
use App\Traits\Utilities;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Notifications\Auth\Welcome as WelcomeNotification;

class UserController extends Controller
{
    use Utilities;

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     * @throws Exception
     */
    public function index()
    {
        $this->authorize('users.index');

        if (request()->ajax()) {
            $users = User::query();

            return DataTables::of($users)
                ->addColumn('email', function ($user) {
                    $email = '<a href="mailto:' . $user->email . '" class="card-link" title="Send E-mail" target="_blank">' . $user->email . '</a>';

                    if ($user->role !== '') {
                        $email .= ' <small class="text-muted">(' . $user->role . ')</small>';
                    }

                    return $email;
                })
                ->addColumn('actions', function ($user) {
                    $actions = '';

                    if (auth()->user()->can('users.delete') && Auth::user()->id !== $user->id) {
                        $actions .= '<a href="' . route(
                            'admin.users.delete',
                            ['user' => $user->uuid]
                        ) . '" class="card-link text-danger"><i class="fas fa-trash" title="Delete"></i></a>';
                    }

                    if (auth()->user()->can('users.edit')) {
                        $actions .= '<a href="' . route(
                            'admin.users.edit',
                            ['user' => $user->uuid]
                        ) . '" class="card-link"><i class="fas fa-edit" title="Edit"></i></a>';
                    }

                    if (auth()->user()->can('users.show')) {
                        $actions .= '<a href="' . route(
                            'admin.users.show',
                            ['user' => $user->uuid]
                        ) . '" class="card-link"><i class="fas fa-info" title="View"></i></a>';
                    }

                    return $actions;
                })
                ->rawColumns(['email', 'actions'])
                ->toJson(true);
        }

        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('users.create');

        $roles = Role::all();

        return view('admin.users.create', [
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->authorize('users.create');

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'roles' => ['nullable', 'exists:roles,id'],
        ]);

        try {
            $user = User::create([
                'uuid' => $this->generateUuid(),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($this->generateUuid()),
            ]);

            if (!is_null($request->roles)) {
                $roles = Role::whereIn('id', $request->roles)->pluck('name')->toArray();
                $user->assignRole($roles);
            }

            WelcomeToken::create([
                'user_id' => $user->id,
                'token' => $this->generateUuid(),
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

        try {
            $user->notify(new WelcomeNotification());

            return redirect()->route('admin.users.index')->with([
                'alert' => (object) [
                    'type' => 'success',
                    'text' => 'User Created',
                ],
            ]);
        } catch (Exception $ex) {
            Log::error($ex);

            return redirect()->back()->withInput()->with([
                'alert' => (object) [
                    'type' => 'danger',
                    'text' => 'Notification Error Occurred',
                ],
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param uuid $uuid
     * @return Response
     */
    public function show($uuid)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param uuid $uuid
     * @return Response
     */
    public function edit($uuid)
    {
        $this->authorize('users.edit');

        $user = User::where('uuid', $uuid)->firstOrFail();
        $roles = Role::all();
        $currentRoles = $user->roles()->pluck('id')->toArray();

        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $roles,
            'currentRoles' => $currentRoles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param uuid $uuid
     * @return Response
     */
    public function update(Request $request, $uuid)
    {
        $this->authorize('users.edit');

        $user = User::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'roles' => ['nullable', 'exists:roles,id'],
        ]);

        try {
            $currentEmail = $user->email;

            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
            ]);

            if ($request->email !== $currentEmail) {
                $user->update(['email_verified_at' => null]);
                $user->sendEmailVerificationNotification();
            }

            $roles = (is_null($request->roles)) ? [] : Role::whereIn('id', $request->roles)->pluck('name')->toArray();
            $user->syncRoles($roles);

            return redirect()->back()->with([
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
     * Show the view for deleting the specified resource.
     *
     * @param uuid $uuid
     * @return Response
     */
    public function delete($uuid)
    {
        $this->authorize('users.delete');

        $user = User::where('uuid', $uuid)->firstOrFail();

        if (Auth::user()->uuid === $user->uuid) {
            return redirect()->route('admin.users.index')->with([
                'alert' => (object) [
                    'type' => 'danger',
                    'text' => 'Permission Denied',
                ],
            ]);
        }

        return view('admin.users.delete', [
            'user' => $user,
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
        $this->authorize('users.delete');

        $user = User::where('uuid', $uuid)->firstOrFail();

        if (Auth::user()->uuid === $user->uuid) {
            return redirect()->route('admin.users.index')->with([
                'alert' => (object) [
                    'type' => 'danger',
                    'text' => 'Permission Denied',
                ],
            ]);
        }

        try {
            $user->delete();

            return redirect()->route('admin.users.index')->with([
                'alert' => (object) [
                    'type' => 'success',
                    'text' => 'User Deleted',
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
