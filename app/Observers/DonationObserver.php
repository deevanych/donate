<?php

namespace App\Observers;

use App\Events\DonationCreated;
use App\Events\MediaReceived;
use App\Models\Donation;
use App\Models\Video;
use Illuminatech\Balance\Facades\Balance;

class DonationObserver
{
    /**
     * Handle the Donation "created" event.
     *
     * @param Donation $donation
     * @return void
     */
    public function created(Donation $donation)
    {
        //
        DonationCreated::dispatch($donation);

        if (isset($donation->media)) {
            $video = new Video($donation->media);

            if (count($video->checkPlayingPossibility()) === 0) {
                $widgetId = $donation->__get('user')->getMediaWidget()->__get('uuid');
                MediaReceived::dispatch($widgetId, $donation->media);
            }
        }
        Balance::increase($donation->user_to, $donation->sum);
    }

    /**
     * Handle the Donation "creating" event.
     *
     * @param Donation $donation
     * @return void
     */
    public function creating(Donation $donation)
    {
        //
    }

    /**
     * Handle the Donation "updated" event.
     *
     * @param Donation $donation
     * @return void
     */
    public function updated(Donation $donation)
    {
        //
    }

    /**
     * Handle the Donation "deleted" event.
     *
     * @param Donation $donation
     * @return void
     */
    public function deleted(Donation $donation)
    {
        //
    }

    /**
     * Handle the Donation "restored" event.
     *
     * @param Donation $donation
     * @return void
     */
    public function restored(Donation $donation)
    {
        //
    }

    /**
     * Handle the Donation "force deleted" event.
     *
     * @param Donation $donation
     * @return void
     */
    public function forceDeleted(Donation $donation)
    {
        //
    }
}
