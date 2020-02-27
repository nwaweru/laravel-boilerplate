<?php

use Carbon\Carbon;
use App\Models\User;
use App\Traits\Utilities;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

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
        User::create([
            'uuid' => $this->generateUuid(),
            'first_name' => 'Ndirangu',
            'last_name' => 'Waweru',
            'email' => 'ndiranguwaweru@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password')
        ]);

        if (app()->environment('local')) {
            factory(User::class, 50)->create();
        }
    }
}
