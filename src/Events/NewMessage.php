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

    public $id;
    public $user;
    public $username;
    public $admin;
    public $ticket;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $id, $admin, $ticket, $message, $username)
    {
        $this->id = $id;
        $this->user = $user;
        $this->username = $username;
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
            'username' => $this->username,
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