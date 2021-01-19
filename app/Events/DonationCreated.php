<?php

namespace App\Events;

use App\Models\Donation;
use App\Models\User;
use App\Services\Yandex;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DonationCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $donation;
    public $speech_uri;

    /**
     * Create a new event instance.
     *
     * @param Donation $donation
     */
    public function __construct(Donation $donation)
    {
        //
        $this->speech_uri = Yandex::TTS($donation);
        $this->donation = $donation;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('channel-'.$this->donation->user_to);
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'donation.created';
    }
}
