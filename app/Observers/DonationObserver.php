<?php

namespace App\Observers;

use App\Events\DonationCreated;
use App\Models\Donation;
use App\Services\Yandex;

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
        return true;
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
