<?php

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

        $pages = [
            [
                'group_id' => 1,
                'name' => 'home',
                'display_name' => 'Dashboard',
            ],
        ];

        $users = [
            [
                'group_id' => 2,
                'name' => 'users.index',
                'display_name' => 'Browse',
            ],
            [
                'group_id' => 2,
                'name' => 'users.create',
                'display_name' => 'Create',
            ],
            [
                'group_id' => 2,
                'name' => 'users.show',
                'display_name' => 'Read',
            ],
            [
                'group_id' => 2,
                'name' => 'users.edit',
                'display_name' => 'Update',
            ],
            [
                'group_id' => 2,
                'name' => 'users.delete',
                'display_name' => 'Delete',
            ],
        ];

        $roles = [
            [
                'group_id' => 3,
                'name' => 'roles.index',
                'display_name' => 'Browse',
            ],
            [
                'group_id' => 3,
                'name' => 'roles.create',
                'display_name' => 'Create',
            ],
            [
                'group_id' => 3,
                'name' => 'roles.show',
                'display_name' => 'Read',
            ],
            [
                'group_id' => 3,
                'name' => 'roles.edit',
                'display_name' => 'Update',
            ],
            [
                'group_id' => 3,
                'name' => 'roles.delete',
                'display_name' => 'Delete',
            ],
        ];

        $permissions = array_merge($pages, $users, $roles);

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
