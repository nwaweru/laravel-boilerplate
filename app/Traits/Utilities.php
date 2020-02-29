<?php

namespace App\Traits;

use App\Models\PermissionGroup;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

trait Utilities
{
    /**
     * Generate a v5 uuid.
     *
     * @return string
     */
    public function generateUuid()
    {
        $uuid = Uuid::uuid5(Uuid::NAMESPACE_DNS, md5(uniqid(Carbon::now(), true)));

        return $uuid->toString();
    }

    /**
     * Get an array of a user's roles.
     */
    public function getUserRoles($user)
    {
        return $user->roles()->pluck('name')->toArray();
    }

    /**
     * Get an array of a user's permission groups.
     */
    public function getUserPermissionGroups($user)
    {
        $permissionGroups = $user->getAllPermissions()->pluck('permission_group_id')->toArray();

        return PermissionGroup::whereIn('id', $permissionGroups)->pluck('id')->toArray();
    }

    /**
     * Get an array of a user's permissions.
     */
    public function getUserPermissions($user)
    {
        return $user->getAllPermissions()->pluck('name')->toArray();
    }
}
