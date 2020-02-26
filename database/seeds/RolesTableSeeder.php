<?php

use App\Traits\Utilities;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    use Utilities;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'uuid' => $this->generateUuid(),
            'name' => 'administrator',
            'display_name' => 'Administrator',
        ])->givePermissionTo(Permission::all());

        Role::create([
            'uuid' => $this->generateUuid(),
            'name' => 'user',
            'display_name' => 'User',
        ])->givePermissionTo([
            'home', 'users.edit',
        ]);
    }
}
