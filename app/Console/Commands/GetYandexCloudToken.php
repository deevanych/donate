<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class GetYandexCloudToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'yandex:getToken';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Yandex cloud token';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Client([
            'base_uri' => 'https://iam.api.cloud.yandex.net/iam/v1/',
            'timeout'  => 10.0,
        ]);

        try {
            $response = $client->request('POST', 'tokens', [
                'query' => [
                    'yandexPassportOauthToken' => env('YANDEX_PASSPORT_OAUTH_TOKEN'),
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            settings()->set('yandex_token', $data['iamToken']);

            echo 'Token has been updated successfully!';
        } catch (GuzzleException $e) {

            echo "Error: {$e->getMessage()}";
        }
    }
}
