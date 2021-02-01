<?php

namespace App\Observers;

use App\Events\DonationCreated;
use App\Events\MediaReceived;
use App\Models\Donation;

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
        if ($donation->media) {
            MediaReceived::dispatch('f0c71c5bb19f6d7f0a98022ff2e1a59ea768008914de469d6dda3adc9bfccc88', $donation->media);
        }
        DonationCreated::dispatch($donation);
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
