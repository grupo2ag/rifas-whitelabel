<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PixPayment implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $uuid;

    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public function broadcastOn()
    {
        return new Channel("Processed.Pix.{$this->uuid}");
    }

    public function broadcastAs()
    {
        return 'PixConfirmed';
    }

    public function broadcastWith()
    {
        return [
            'uuid' => $this->uuid,
            'status' => 1,
            'payed' => true
        ];
    }
}
