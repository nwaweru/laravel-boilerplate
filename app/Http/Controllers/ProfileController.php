<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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
        $user = User::where('id', Auth::user()->id)->where('uuid', $uuid)->firstOrFail();

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
        $user = User::where('id', Auth::user()->id)->where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
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

                return redirect()->route('home');
            }

            return redirect()->route('profile.edit', ['user' => $user->uuid])->with([
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
