<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use App\Http\Controllers\Controller;

class AuditController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function auditing()
    {
        return view('admin.audit.auditing');
    }
}
