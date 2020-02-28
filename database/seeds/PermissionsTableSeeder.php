<?php

use App\Models\PermissionGroup;
use App\Traits\Utilities;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            'permissions' => PermissionGroup::where('name', 'Permissions')->first(),
            'audit' => PermissionGroup::where('name', 'Audit')->first(),
        ];

        $users = [
            [
                'permission_group_id' => $permissionGroup['users']->id,
                'name' => 'users.index',
                'display_name' => 'Browse',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['users']->id,
                'name' => 'users.create',
                'display_name' => 'Create',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['users']->id,
                'name' => 'users.show',
                'display_name' => 'Read',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['users']->id,
                'name' => 'users.edit',
                'display_name' => 'Update',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['users']->id,
                'name' => 'users.delete',
                'display_name' => 'Delete',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        $roles = [
            [
                'permission_group_id' => $permissionGroup['roles']->id,
                'name' => 'roles.index',
                'display_name' => 'Browse',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['roles']->id,
                'name' => 'roles.create',
                'display_name' => 'Create',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['roles']->id,
                'name' => 'roles.show',
                'display_name' => 'Read',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['roles']->id,
                'name' => 'roles.edit',
                'display_name' => 'Update',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['roles']->id,
                'name' => 'roles.delete',
                'display_name' => 'Delete',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        $permissions = [
            [
                'permission_group_id' => $permissionGroup['permissions']->id,
                'name' => 'permissions.index',
                'display_name' => 'Browse',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['permissions']->id,
                'name' => 'permissions.create',
                'display_name' => 'Create',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['permissions']->id,
                'name' => 'permissions.show',
                'display_name' => 'Read',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['permissions']->id,
                'name' => 'permissions.edit',
                'display_name' => 'Update',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'permission_group_id' => $permissionGroup['permissions']->id,
                'name' => 'permissions.delete',
                'display_name' => 'Delete',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        $audit = [
            [
                'permission_group_id' => $permissionGroup['audit']->id,
                'name' => 'auditing.index',
                'display_name' => 'Auditing',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        $mergedPermissions = array_merge($users, $roles, $permissions, $audit);

        DB::table('permissions')->insert($mergedPermissions);
    }
}
