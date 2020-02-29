<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Permission extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    /**
     * Get the permission group for the permission.
     */
    public function permissionGroup()
    {
        return $this->belongsTo(PermissionGroup::class);
    }
}
