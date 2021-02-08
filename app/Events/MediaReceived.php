<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MediaReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $token;
    public $uri;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($token, $uri)
    {
        //
        $this->token = $token;
        $this->uri = $uri;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel("channel-$this->token");
    }

    public function broadcastAs(): string
    {
        return 'media.received';
    }
}
