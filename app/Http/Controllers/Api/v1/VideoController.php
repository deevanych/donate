<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     */
    public function __invoke(Request $request): array
    {
        //
        $video = new Video($request->get('uri'));

        return $video->checkPlayingPossibility();
    }
}
