<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Models\Permission;

class PermissionGroup extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'name',
    ];

    /**
     * Get the permissions for the group.
     */
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
