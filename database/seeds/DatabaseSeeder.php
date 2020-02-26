<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionGroupsTableSeeder::class,
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
        ]);

        $this->call(UsersTableSeeder::class);

        if (app()->environment('local')) {
            $this->call(DummyDataSeeder::class);
        }
    }
}
