<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Yandex
{
    const VOICES = [
        'alena',
        'filipp',
        'omazh'
    ];

    public static function TTS($donation)
    {
        $client = new Client([
            'base_uri' => 'https://tts.api.cloud.yandex.net/speech/v1/tts:synthesize',
            'timeout' => 10.0,
            'headers' => [
                'Authorization' => "Bearer " . settings()->get('yandex_token'),
            ]
        ]);

        try {
            $response = $client->request('POST', '', [
                'query' => [
                    'text' => $donation->text,
                    'folderId' => env('YANDEX_FOLDER_ID'),
                    'voice' => self::VOICES[1],
                    'speed' => 1.1,
                    'emotion' => 'neutral',
                ]
            ]);

            $speechBinary = $response->getBody()->getContents();
            $hashParameters = [
                $donation->user_to,
                time(),
                $donation->sum,
            ];
            $speechFileName = Hash::make(implode('', $hashParameters)) . ".ogg";
            Storage::disk('temp')->put($speechFileName, $speechBinary);

            return asset(Storage::disk('temp')->url($speechFileName));
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }
    }
}
