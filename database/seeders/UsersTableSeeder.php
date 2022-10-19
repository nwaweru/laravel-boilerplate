<?php

namespace Database\Seeders;

use App\Models\User;
use App\Traits\Utilities;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    use Utilities;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a super user account.
        $this->createSuperUser([
            'uuid' => $this->generateUuid(),
            'first_name' => 'Ndirangu',
            'last_name' => 'Waweru',
            'email' => 'nwaweru@drash.co.ke',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ]);

        // Create a normal user account.
        $this->createNormalUser([
            'uuid' => $this->generateUuid(),
            'first_name' => 'Ndirangu',
            'last_name' => 'Waweru',
            'email' => 'ndiranguwaweru@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ]);
    }

    /**
     * Create a super user.
     *
     * @param  array  $user
     * @return void
     */
    private function createSuperUser($user)
    {
        Role::create([
            'uuid' => $this->generateUuid(),
            'name' => 'Super User',
        ])->givePermissionTo(Permission::all());

        $user = User::create($user);

        $user->assignRole('Super User');
    }

    /**
     * Create a normal user.
     *
     * @param  array  $user
     * @return void
     */
    private function createNormalUser($user)
    {
        // Create a normal account.
        User::create($user);
    }
}
