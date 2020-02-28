<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\WelcomeToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class WelcomeController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param uuid $token
     * @return \Illuminate\Http\Response
     */
    public function setPassword(Request $request, $token)
    {
        $welcomeToken = WelcomeToken::where('token', $token)->firstOrFail();
        $user = $welcomeToken->user()->where('email', $request->email)->firstOrFail();

        if ($request->isMethod('put')) {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            try {
                $user->update([
                    'email_verified_at' => Carbon::now(),
                    'password' => Hash::make($request->password),
                ]);

                $welcomeToken->delete();

                return redirect()->route('profile.edit', ['user' => $user->uuid])->with([
                    'alert' => (object) [
                        'type' => 'success',
                        'text' => 'Changes Saved',
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

        return view('auth.welcome', [
            'user' => $user,
        ]);
    }
}
