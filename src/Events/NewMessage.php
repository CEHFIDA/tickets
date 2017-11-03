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
    public $id;
    public $admin;
    public $ticket;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $id, $admin, $ticket, $message)
    {
        $this->user = $user;
        $this->id = $id;
        $this->admin = $admin;
        $this->ticket = $ticket;
        $this->message = $message;
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
        return [
            'id' => $this->id, 
            'user' => $this->user, 
            'is_admin' => $this->admin, 
            'new_ticket' => $this->ticket,
            'message' => $this->message
        ];
    }

    public function broadcastAs()
    {
        return 'message';
    }
}
