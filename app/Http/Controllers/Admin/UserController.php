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
use App\Traits\Utilities;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
                ->addColumn('name', function ($user) {
                    return $user->first_name . ' ' . $user->last_name;
                })
                ->addColumn('roles', function ($user) {
                    $roles = $user->roles()->pluck('display_name')->toArray();
                    return $roles;
                })
                ->addColumn('actions', function ($user) {
                    $actions = '';

                    if (auth()->user()->can('users.delete')) {
                        $actions .= '<a href="' . route(
                            'users.delete',
                            ['user' => $user->uuid]
                        ) . '" class="card-link text-danger"><i class="fas fa-trash" title="Delete"></i></a>';
                    }

                    if (auth()->user()->can('users.edit')) {
                        $actions .= '<a href="' . route(
                            'users.edit',
                            ['user' => $user->uuid]
                        ) . '" class="card-link"><i class="fas fa-edit" title="Edit"></i></a>';
                    }

                    if (auth()->user()->can('users.show')) {
                        $actions .= '<a href="' . route(
                            'users.show',
                            ['user' => $user->uuid]
                        ) . '" class="card-link"><i class="fas fa-info" title="View"></i></a>';
                    }

                    return $actions;
                })
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

        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        $this->authorize('users.create');

        try {
            User::create([
                'uuid' => $this->generateUuid(),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($this->generateUuid()),
            ]);

            return redirect()->route('users.index')->with([
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
                    'text' => 'Database Error Occurred',
                ],
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
