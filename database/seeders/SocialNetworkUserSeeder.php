<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocialNetworkUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('social_network_user')->insert([
            'user_id' => 1,
            'social_network_id' => 1,
            'link' => 'https://www.twitch.tv/deevanich',
        ]);
    }
}
