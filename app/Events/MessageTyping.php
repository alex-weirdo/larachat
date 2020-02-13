<?php

namespace App\Events;

use App\User;
use App\Message;
use App\Room;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageTyping implements ShouldBroadcast
{
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public $user_name;
	public $room_id;

	public function __construct($user_name, $room_id)
	{
		$this->user_name = $user_name;
		$this->room_id = $room_id;
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return \Illuminate\Broadcasting\Channel|array
	 */
	public function broadcastOn()
	{
		return new Channel('channel_'.$this->room_id);
	}
}
