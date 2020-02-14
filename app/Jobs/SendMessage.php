<?php

namespace App\Jobs;

use App\Events\MessageSent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Bus\PendingDispatch;
use PHPUnit\Framework\MockObject\Exception;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $room;
    public $message;

    /**
     * SendMessage constructor.
     * @param $user
     * @param $room
     * @param $message
     */
    public function __construct($user, $room, $message)
    {
        $this->user = $user;
        $this->room = $room;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        die(500);
        broadcast(new MessageSent($this->user, $this->room, $this->message))->toOthers();
    }

    /**
     * так можно сообщить об ошибке в очереди
     */
    public function failed () {
        $token = '';
        $chat_id = 12345;
        $text = 'Произошла ошибка в очереди!';

        @file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=$text&parse_mode=html");
    }
}
