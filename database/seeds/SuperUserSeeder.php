<?php

use Carbon\Carbon;
use App\Models\User;
use App\Traits\Utilities;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class SuperUserSeeder extends Seeder
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
            'name' => 'super-user',
            'display_name' => 'Super User',
        ])->givePermissionTo(Permission::all());

        $user = User::create([
            'uuid' => $this->generateUuid(),
            'first_name' => 'Ndirangu',
            'last_name' => 'Waweru',
            'email' => 'nwaweru@live.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password')
        ]);

        $user->assignRole('super-user');
    }
}
