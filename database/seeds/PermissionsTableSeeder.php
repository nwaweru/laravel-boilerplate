<?php

use App\Models\PermissionGroup;
use App\Traits\Utilities;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
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

        $group = [
            'pages' => PermissionGroup::where('name', 'Pages')->first(),
            'users' => PermissionGroup::where('name', 'Users')->first(),
            'roles' => PermissionGroup::where('name', 'Roles')->first(),
            'permissions' => PermissionGroup::where('name', 'Permissions')->first(),
            'audit' => PermissionGroup::where('name', 'Audit')->first(),
        ];

        $pages = [
            [
                'group_id' => $group['pages']->id,
                'name' => 'home',
                'display_name' => 'Dashboard',
            ],
        ];

        $users = [
            [
                'group_id' => $group['users']->id,
                'name' => 'users.index',
                'display_name' => 'Browse',
            ],
            [
                'group_id' => $group['users']->id,
                'name' => 'users.create',
                'display_name' => 'Create',
            ],
            [
                'group_id' => $group['users']->id,
                'name' => 'users.show',
                'display_name' => 'Read',
            ],
            [
                'group_id' => $group['users']->id,
                'name' => 'users.edit',
                'display_name' => 'Update',
            ],
            [
                'group_id' => $group['users']->id,
                'name' => 'users.delete',
                'display_name' => 'Delete',
            ],
        ];

        $roles = [
            [
                'group_id' => $group['roles']->id,
                'name' => 'roles.index',
                'display_name' => 'Browse',
            ],
            [
                'group_id' => $group['roles']->id,
                'name' => 'roles.create',
                'display_name' => 'Create',
            ],
            [
                'group_id' => $group['roles']->id,
                'name' => 'roles.show',
                'display_name' => 'Read',
            ],
            [
                'group_id' => $group['roles']->id,
                'name' => 'roles.edit',
                'display_name' => 'Update',
            ],
            [
                'group_id' => $group['roles']->id,
                'name' => 'roles.delete',
                'display_name' => 'Delete',
            ],
        ];

        $permissions = [
            [
                'group_id' => $group['permissions']->id,
                'name' => 'permissions.index',
                'display_name' => 'Browse',
            ],
            [
                'group_id' => $group['permissions']->id,
                'name' => 'permissions.create',
                'display_name' => 'Create',
            ],
            [
                'group_id' => $group['permissions']->id,
                'name' => 'permissions.show',
                'display_name' => 'Read',
            ],
            [
                'group_id' => $group['permissions']->id,
                'name' => 'permissions.edit',
                'display_name' => 'Update',
            ],
            [
                'group_id' => $group['permissions']->id,
                'name' => 'permissions.delete',
                'display_name' => 'Delete',
            ],
        ];

        $audit = [
            [
                'group_id' => $group['audit']->id,
                'name' => 'auditing.index',
                'display_name' => 'Laravel Auditing',
            ],
        ];

        $combined = array_merge($pages, $users, $roles, $permissions, $audit);

        foreach ($combined as $permission) {
            Permission::create($permission);
        }
    }
}
