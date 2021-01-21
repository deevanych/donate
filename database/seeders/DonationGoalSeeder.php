<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DonationGoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('donation_goals')->insert([
            'title' => 'На диван',
            'sum_goal' => 20000,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('donation_goals')->insert([
            'title' => 'На любовницу',
            'sum_goal' => 3000,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('donation_goals')->insert([
            'title' => 'На камеру',
            'sum_goal' => 10000,
            'user_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
