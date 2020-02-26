<?php

use App\Traits\Utilities;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionGroupsTableSeeder extends Seeder
{
    use Utilities;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            [
                'id' => 1,
                'uuid' => $this->generateUuid(),
                'name' => 'Pages',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'uuid' => $this->generateUuid(),
                'name' => 'Users',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'uuid' => $this->generateUuid(),
                'name' => 'Roles',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'uuid' => $this->generateUuid(),
                'name' => 'Audit',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('permission_groups')->insert($groups);
    }
}
