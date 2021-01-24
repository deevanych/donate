<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'deevanich',
            'email' => 'cashalotkzn@gmail.com',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('users')->insert([
            'name' => 'tanisat',
            'email' => 'test1@test.com',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
