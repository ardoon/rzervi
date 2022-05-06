<?php

namespace App\Events;

use App\Models\Request;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The request instance.
     *
     * @var Request
     */
    public $request;

    public $type;
    public $mode;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Request $request, String $type, $mode = null)
    {
        $this->request = $request;
        $this->type = $type;
        $this->mode = $mode;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn()
    {
        $id = $this->getId();
        return new PrivateChannel('users.' . $id);
    }

    public function getId()
    {
        $id = $this->request->requester;

        if ($this->type === 'responder') {
            $user = User::where('provider_id', $this->request->responder)->first();
            $id = $user->id;
        }

        return $id;
    }

}
