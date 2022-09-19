<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;

class AuditController extends Controller
{
    /**
     * Show the application audit log.
     *
     * @return Renderable
     */
    public function auditing()
    {
        return view('admin.audit.auditing');
    }
}
