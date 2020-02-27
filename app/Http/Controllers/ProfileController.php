<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param uuid $uuid
     * @return Response
     */
    public function edit($uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();

        if (Auth::user()->uuid !== $user->uuid) {
            abort(403);
        }

        return view('profile.edit', [
            'user' => $user,
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
        $user = User::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        if (Auth::user()->uuid !== $user->uuid) {
            abort(403);
        }

        try {
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
            ]);

            return redirect()->route('users.edit', ['user' => $user->uuid])->with([
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
}
