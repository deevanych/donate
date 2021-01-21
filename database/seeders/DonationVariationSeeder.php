<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DonationVariationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('donation_variations')->insert([
            'title' => 'минимум',
            'sum' => 100,
            'description' => 'Минимальная сумма для доната',
            'user_id' => 1,
            'appearance' => json_encode([
                'background' => [
                    'to right',
                    '#f12711',
                    '#f5af19',
                ],
                'color' => '#FFFFFF',
            ]),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('donation_variations')->insert([
            'title' => 'танцую',
            'sum' => 1000,
            'description' => 'Танцую под вашу музыку',
            'user_id' => 1,
            'appearance' => json_encode([
                'background' => [
                    'to right',
                    '#659999',
                    '#f4791f',
                ],
                'color' => '#FFFFFF',
            ]),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('donation_variations')->insert([
            'title' => 'скример',
            'sum' => 666,
            'description' => 'Орущий мужик',
            'user_id' => 1,
            'appearance' => json_encode([
                'background' => [
                    'to right',
                    '#dd3e54',
                    '#6be585',
                ],
                'color' => '#FFFFFF',
            ]),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('donation_variations')->insert([
            'title' => 'спасибо',
            'sum' => 2000,
            'description' => 'Скажу спасибо',
            'user_id' => 1,
            'appearance' => json_encode([
                'background' => [
                    'to right',
                    '#8360c3',
                    '#2ebf91',
                ],
                'color' => '#FFFFFF',
            ]),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
