<?php

namespace App\Observers;

use App\Events\DonationCreated;
use App\Events\MediaReceived;
use App\Models\Donation;
use App\Services\YoutubeVideo;
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
        if ($donation->media && YoutubeVideo::checkVideo($donation->media)) {
//            todo
            $user = $donation->getReceiver()->first();
            dd($user->getWidgets());
            MediaReceived::dispatch('3b64c7c4-19e9-4b3c-845a-4254116ab482', $donation->media);
        }
        DonationCreated::dispatch($donation);
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
