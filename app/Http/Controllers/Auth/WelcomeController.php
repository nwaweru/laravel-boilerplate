<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\WelcomeToken;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class WelcomeController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @param  uuid  $token
     * @return Response
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

                $user->welcomeToken->delete();

                if (Auth::attempt($request->only('email', 'password'))) {
                    return redirect()->route('home');
                }

                return redirect()->route('login');
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

        return view('auth.welcome', [
            'user' => $user,
        ]);
    }
}
