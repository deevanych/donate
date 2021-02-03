<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WidgetTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('widget_types')->insert([
            'title' => 'Уведомления',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('widget_types')->insert([
            'title' => 'Сборы',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('widget_types')->insert([
            'title' => 'Медиа',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('widget_types')->insert([
            'title' => 'Статистика',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
