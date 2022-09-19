<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class WelcomeController extends Controller
{
    /**
     * Show the welcome page.
     *
     * @return Renderable
     */
    public function index()
    {
        // return view('welcome');
        return redirect()->route('home');
    }
}
