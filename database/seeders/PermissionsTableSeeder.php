<?php

namespace Database\Seeders;

use App\Models\PermissionGroup;
use App\Traits\Utilities;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\PermissionRegistrar;

class PermissionsTableSeeder extends Seeder
{
    use Utilities;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissionGroup = [
            'users' => PermissionGroup::where('name', 'Users')->first(),
            'roles' => PermissionGroup::where('name', 'Roles')->first(),
            'permissionGroups' => PermissionGroup::where('name', 'Permission Groups')->first(),
            'permissions' => PermissionGroup::where('name', 'Permissions')->first(),
            'audits' => PermissionGroup::where('name', 'Audits')->first(),
        ];

        $users = [
            [
                'permission_group_id' => $permissionGroup['users']->id,
                'uuid' => $this->generateUuid(),
                'name' => 'users.index',
                'display_name' => 'Browse Users',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['users']->id,
                'uuid' => $this->generateUuid(),
                'name' => 'users.create',
                'display_name' => 'Create User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['users']->id,
                'uuid' => $this->generateUuid(),
                'name' => 'users.show',
                'display_name' => 'View User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['users']->id,
                'uuid' => $this->generateUuid(),
                'name' => 'users.edit',
                'display_name' => 'Update User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['users']->id,
                'uuid' => $this->generateUuid(),
                'name' => 'users.delete',
                'display_name' => 'Delete User',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        $roles = [
            [
                'permission_group_id' => $permissionGroup['roles']->id,
                'uuid' => $this->generateUuid(),
                'name' => 'roles.index',
                'display_name' => 'Browse Roles',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['roles']->id,
                'uuid' => $this->generateUuid(),
                'name' => 'roles.create',
                'display_name' => 'Create Role',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['roles']->id,
                'uuid' => $this->generateUuid(),
                'name' => 'roles.show',
                'display_name' => 'View Role',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['roles']->id,
                'uuid' => $this->generateUuid(),
                'name' => 'roles.edit',
                'display_name' => 'Update Role',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['roles']->id,
                'uuid' => $this->generateUuid(),
                'name' => 'roles.delete',
                'display_name' => 'Delete Role',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        $permissionGroups = [
            [
                'permission_group_id' => $permissionGroup['permissionGroups']->id,
                'uuid' => $this->generateUuid(),
                'name' => 'permissionGroups.index',
                'display_name' => 'Browse Permission Groups',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['permissionGroups']->id,
                'uuid' => $this->generateUuid(),
                'name' => 'permissionGroups.create',
                'display_name' => 'Create Permission Group',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['permissionGroups']->id,
                'uuid' => $this->generateUuid(),
                'name' => 'permissionGroups.show',
                'display_name' => 'View Permission Group',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['permissionGroups']->id,
                'uuid' => $this->generateUuid(),
                'name' => 'permissionGroups.edit',
                'display_name' => 'Update Permission Group',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['permissionGroups']->id,
                'uuid' => $this->generateUuid(),
                'name' => 'permissionGroups.delete',
                'display_name' => 'Delete Permission Group',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        $permissions = [
            [
                'permission_group_id' => $permissionGroup['permissions']->id,
                'uuid' => $this->generateUuid(),
                'name' => 'permissions.index',
                'display_name' => 'Browse Permissions',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['permissions']->id,
                'uuid' => $this->generateUuid(),
                'name' => 'permissions.create',
                'display_name' => 'Create Permission',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['permissions']->id,
                'uuid' => $this->generateUuid(),
                'name' => 'permissions.show',
                'display_name' => 'View Permission',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['permissions']->id,
                'uuid' => $this->generateUuid(),
                'name' => 'permissions.edit',
                'display_name' => 'Update Permission',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['permissions']->id,
                'uuid' => $this->generateUuid(),
                'name' => 'permissions.delete',
                'display_name' => 'Delete Permission',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        $audit = [
            [
                'permission_group_id' => $permissionGroup['audits']->id,
                'uuid' => $this->generateUuid(),
                'name' => 'auditing.index',
                'display_name' => 'Laravel Auditing',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        $mergedPermissions = array_merge($users, $roles, $permissionGroups, $permissions, $audit);

        DB::table('permissions')->insert($mergedPermissions);
    }
}
