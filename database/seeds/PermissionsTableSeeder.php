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

        $group = PermissionGroup::where('name', 'Pages')->first();
        $pages = [
            [
                'group_id' => $group->id,
                'name' => 'home',
                'display_name' => 'Dashboard',
            ],
        ];

        $group = PermissionGroup::where('name', 'Users')->first();
        $users = [
            [
                'group_id' => $group->id,
                'name' => 'users.index',
                'display_name' => 'Browse',
            ],
            [
                'group_id' => $group->id,
                'name' => 'users.create',
                'display_name' => 'Create',
            ],
            [
                'group_id' => $group->id,
                'name' => 'users.show',
                'display_name' => 'Read',
            ],
            [
                'group_id' => $group->id,
                'name' => 'users.edit',
                'display_name' => 'Update',
            ],
            [
                'group_id' => $group->id,
                'name' => 'users.delete',
                'display_name' => 'Delete',
            ],
        ];

        $group = PermissionGroup::where('name', 'Users')->first();
        $roles = [
            [
                'group_id' => $group->id,
                'name' => 'roles.index',
                'display_name' => 'Browse',
            ],
            [
                'group_id' => $group->id,
                'name' => 'roles.create',
                'display_name' => 'Create',
            ],
            [
                'group_id' => $group->id,
                'name' => 'roles.show',
                'display_name' => 'Read',
            ],
            [
                'group_id' => $group->id,
                'name' => 'roles.edit',
                'display_name' => 'Update',
            ],
            [
                'group_id' => $group->id,
                'name' => 'roles.delete',
                'display_name' => 'Delete',
            ],
        ];

        $group = PermissionGroup::where('name', 'Audit')->first();
        $audit = [
            [
                'group_id' => $group->id,
                'name' => 'auditing.index',
                'display_name' => 'Laravel Auditing',
            ],
        ];

        $permissions = array_merge($pages, $users, $roles, $audit);

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
