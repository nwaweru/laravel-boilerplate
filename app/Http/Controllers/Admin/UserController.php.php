<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WelcomeToken;
use App\Notifications\Auth\Welcome as WelcomeNotification;
use App\Traits\Utilities;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    use Utilities;

    /**
     * Display a listing of the resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('users.index');

        if (request()->ajax()) {
            $users = User::query();

            return DataTables::of($users)
                ->addColumn('roles', function (User $user) {
                    return implode(', ', $user->roles()->pluck('display_name')->toArray());
                })
                ->addColumn('actions', function (User $user) {
                    $actions = '';

                    if (auth()->user()->can('users.show')) {
                        $actions .= '<a class="card-link" href="' . route('users.show', ['user' => $user->uuid]) . '"><i title="View" class="fas fa-fw fa-info-circle"></i></a>';
                    }

                    if (auth()->user()->can('users.edit')) {
                        $actions .= '<a class="card-link" href="' . route('users.edit', ['user' => $user->uuid]) . '"><i title="Edit" class="fas fa-fw fa-edit"></i></a>';
                    }

                    if (auth()->user()->can('users.delete')) {
                        $actions .= '<a class="card-link text-danger" href="' . route('users.delete', ['user' => $user->uuid]) . '"><i title="Delete" class="fas fa-fw fa-trash-alt"></i></a>';
                    }

                    return $actions;
                })
                ->order(function ($query) {
                    $query->orderBy('first_name', 'asc');
                })
                ->rawColumns(['log', 'actions'])
                ->toJson();
        }

        return view('setup.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('users.create');

        $roles = Role::all();

        return view('setup.users.create', [
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('users.create');

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'roles' => ['required', 'exists:roles,id'],
        ]);

        try {
            $user = User::create([
                'uuid' => $this->generateUuid(),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('s3cr3t'),
            ]);

            $roles = Role::whereIn('id', $request->roles)->pluck('name')->toArray();
            $user->assignRole($roles);
        } catch (Exception $ex) {
            Log::error($ex);

            return redirect()->back()->withInput()->with([
                'alert' => (object)[
                    'type' => 'danger',
                    'text' => 'Internal Error Occurred',
                ],
            ]);
        }

        try {
            $token = WelcomeToken::create([
                'user_id' => $user->id,
                'token' => $this->generateUuid(),
            ]);

            $user->notify(new WelcomeNotification($user, $token->token));

            return redirect()->route('users.show', ['user' => $user->uuid])->with([
                'alert' => (object)[
                    'type' => 'success',
                    'text' => 'User Created',
                ],
            ]);
        } catch (Exception $ex) {
            Log::error($ex);

            return redirect()->back()->withInput()->with([
                'alert' => (object)[
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
     * @return View
     * @throws AuthorizationException
     */
    public function show($uuid)
    {
        if (auth()->user()->uuid !== $uuid) {
            $this->authorize('users.show');
        }

        $user = User::where('uuid', $uuid)->firstOrFail();

        return view('setup.users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param uuid $uuid
     * @return View
     * @throws AuthorizationException
     */
    public function edit($uuid)
    {
        if (auth()->user()->uuid !== $uuid) {
            $this->authorize('users.edit');
        }

        $user = User::where('uuid', $uuid)->firstOrFail();
        $roles = Role::all();
        $currentRoles = $user->roles()->pluck('id')->toArray();

        return view('setup.users.edit', [
            'user' => $user,
            'roles' => $roles,
            'currentRoles' => $currentRoles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param uuid $uuid
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, $uuid)
    {
        if (auth()->user()->uuid !== $uuid) {
            $this->authorize('users.edit');
        }

        $user = User::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'roles' => ['sometimes', 'required', 'exists:roles,id'],
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

            if (!is_null($request->roles)) {
                $roles = Role::whereIn('id', $request->roles)->pluck('name')->toArray();
                $user->syncRoles($roles);
            }

            return redirect()->route('users.show', ['user' => $user->uuid])->with([
                'alert' => (object)[
                    'type' => 'success',
                    'text' => 'Changes Saved',
                ],
            ]);
        } catch (Exception $ex) {
            Log::error($ex);

            return redirect()->back()->withInput()->with([
                'alert' => (object)[
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
     * @throws AuthorizationException
     */
    public function delete($uuid)
    {
        $this->authorize('users.delete');

        $user = User::where('uuid', $uuid)->firstOrFail();

        return view('setup.users.delete', [
            'user' => $user,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param uuid $uuid
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy($uuid)
    {
        $this->authorize('users.delete');

        $user = User::where('uuid', $uuid)->firstOrFail();

        try {
            $user->delete();

            return redirect()->route('users.index')->with([
                'alert' => (object)[
                    'type' => 'success',
                    'text' => 'User Deleted',
                ],
            ]);
        } catch (Exception $ex) {
            Log::error($ex);

            return redirect()->back()->withInput()->with([
                'alert' => (object)[
                    'type' => 'danger',
                    'text' => 'Internal Error Occurred',
                ],
            ]);
        }
    }
}
