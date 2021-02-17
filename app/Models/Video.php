<?php


namespace App\Models;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Video
{

    private string $uri;
    private object $stats;

    public function __construct($uri)
    {
        $this->uri = $uri;
        $this->getVideoInfo();
    }

    public function getVideoInfo()
    {
        $client = new Client([
            'base_uri' => 'https://www.googleapis.com/youtube/v3/videos',
            'timeout' => 10.0,
        ]);

        try {
            $response = $client->request('GET', '', [
                'query' => [
                    'part' => 'snippet,statistics,contentDetails,status',
                    'id' => $this->getId(),
                    'key' => env('GOOGLE_API_KEY'),
                ]
            ]);

            $response = json_decode($response->getBody()->getContents());

            if (isset($response->items[0])) {
                $this->stats = $response->items[0];
            }
        } catch (GuzzleException $e) {
            return $e;
        }
    }

    public function getId(): string
    {
        $pattern = '/^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/';
        preg_match($pattern, $this->uri, $matches);

        return ($matches && strlen($matches[7]) == 11 ? $matches[7] : false);
    }

    public function checkPlayingPossibility(): array
    {
        $errors = [];
        if (!isset($this->stats)) {
            $errors[] = 'not_found';

            return $errors;
        }

        if (isset($this->stats->snippet->liveBroadcastContent) && $this->stats->snippet->liveBroadcastContent === 'live') {
            $errors[] = 'broadcasting';
        }
        if (isset($this->stats->contentDetails->contentRating->ytRating) && $this->stats->contentDetails->contentRating->ytRating === 'ytAgeRestricted') {
            $errors[] = 'adult';
        }
        if (isset($this->stats->status->embeddable) && $this->stats->status->embeddable === false) {
            $errors[] = 'embed_not_allowed';
        }
//        todo
        if (isset($this->stats->statistics->viewCount) && $this->stats->statistics->viewCount <= 10000) {
            $errors[] = 'view_count';
        }
//        todo
        if ($this->getLikesRatio() <= 60) {
            $errors[] = 'likes_ratio';
        }

        return $errors;
    }

    public function getLikesRatio(): int
    {
        if (!isset($this->stats->statistics->likeCount)) {
            return 0;
        }
        $reactionCount = (int)$this->stats->statistics->likeCount + (int)$this->stats->statistics->dislikeCount;
        return $this->stats->statistics->likeCount / $reactionCount * 100;
    }
}
