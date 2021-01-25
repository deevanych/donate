<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OauthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('oauth_clients')->insert([
            'name' => 'site',
            'secret' => 'RnP9voeOq43WOINBrfkTXcLFJePddEKCtyJR9LW2',
            'redirect' => 'http://localhost',
            'password_client' => 0,
            'personal_access_client' => 1,
            'revoked' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
