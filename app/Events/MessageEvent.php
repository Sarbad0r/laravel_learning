<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message = '';
    public $user;
    public $channel_name;
    public $user_id;
    /**
     * Create a new event instance.
     */
    public function __construct($message, $user, $channel_name, $user_id)
    {
        $this->message = $message;
        $this->user = $user;
        $this->channel_name = $channel_name;
        $this->user_id = $user_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array //name of channel
    {
        // return [
        //     new PrivateChannel('channel-name'),
        // ];
        return ["{$this->channel_name}"]; //name of channel 
    }

    public function broadcastAs()
    {
        return 'send.event'; //name of event 
    }

    public function broadcastWith()
    {
        return  [
            'message' => $this->message,
            'user' => $this->user,
            'user_id' => $this->user_id,
            'channel_name' => $this->channel_name
        ]; //after working any fun that calling this event will send message reverse
    }
}
