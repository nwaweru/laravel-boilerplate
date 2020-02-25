<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class AuditController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function auditing()
    {
        return view('audit.auditing');
    }
}
