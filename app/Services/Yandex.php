<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Yandex {

    public static function TTS($donation) {
        $client = new Client([
            'base_uri' => 'https://tts.api.cloud.yandex.net/speech/v1/tts:synthesize',
            'timeout'  => 10.0,
            'headers' => [
                'Authorization' => 'Bearer '.env('YANDEX_TOKEN'),
            ]
        ]);

        try {
            $response = $client->request('POST', '', [
                'query' => [
                    'text' => $donation->text,
                    'folderId' => env('YANDEX_FOLDER_ID')
                ]
            ]);

            $speechBinary = $response->getBody()->getContents();
            $hashParameters = [
                $donation->text,
                time()
            ];
            $speechFileName = Hash::make(implode('', $hashParameters)).".ogg";
            Storage::disk('temp')->put($speechFileName, $speechBinary);

            return Storage::disk('temp')->url($speechFileName);
        } catch (GuzzleException $e) {
            echo $e->getMessage();
        }
    }
}
