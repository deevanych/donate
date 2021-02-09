<?php


namespace App\Services;


use GuzzleHttp\Client;

class YoutubeVideo
{
    public static function getId($uri = '')
    {
        $pattern = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/';
        preg_match($pattern, $uri, $matches);

        return ($matches && strlen($matches[7]) == 11 ? $matches[7] : false);
    }

    public static function checkPlayPossibility($videoId = '')
    {
        $client = new Client([
            'base_uri' => 'https://www.googleapis.com/youtube/v3/videos',
            'timeout' => 10.0,
        ]);

        try {
            $response = $client->request('GET', '', [
                'query' => [
                    'part' => 'snippet,statistics,contentDetails,status',
                    'id' => $videoId,
                    'key' => env('GOOGLE_API_KEY'),
                ]
            ]);

            $videoStats = json_decode($response->getBody()->getContents());
            $video = $videoStats->items[0];
//            dd($video);
//            todo

            if ($video->snippet->liveBroadcastContent === 'live') {
                dd('stream');
            }
            if (isset($video->contentDetails->contentRating->ytRating) && $video->contentDetails->contentRating->ytRating === 'ytAgeRestricted') {
                dd('18+');
            }
            if (!$video->status->embeddable) {
                dd('not embed');
            }

            return true;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function checkVideo($uri = '')
    {
        $videoId = self::getId($uri);

        return self::checkPlayPossibility($videoId);
    }
}
