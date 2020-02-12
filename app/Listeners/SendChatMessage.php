<?php

namespace App\Listeners;

use App\Events\MessageSent;
use App\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendChatMessage
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MessageSent  $event
     * @return void
     */
    public function handle(MessageSent $event)
    {
        //todo: передеть пользователя нормально

        $message = new Message();
        $message->text = $event->message;
        $message->user_id = $event->user_id;
        $message->room_id = $event->room_id;
        $message->save();
        
    }
}
