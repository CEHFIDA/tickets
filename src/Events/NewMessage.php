<?php

namespace Selfreliance\tickets\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewMessage implements ShouldBroadcast
{
    use SerializesModels;

    public $user;
    public $message;
    public $admin;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $message, $admin)
    {
        $this->user = $user;
        $this->message = $message;
        $this->admin = $admin;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['tickets'];
    }

    public function broadcastWith()
    {
        return ['id' => $this->message, 'user' => $this->user, 'is_admin' => $this->admin];
    }

    public function broadcastAs()
    {
        return 'message';
    }
}
