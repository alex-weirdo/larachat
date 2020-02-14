<?php

namespace App\Http\Controllers;

use App\Jobs\SendMessage;
use App\Message;
use App\Events\MessageSent;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use PHPUnit\Framework\MockObject\Stub\Exception;
use Symfony\Component\Console\Output\ConsoleOutput;

use Illuminate\Bus\Queueable;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Message::class);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        return new \App\Http\Resources\MessageResource($message);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy($message)
    {
        $message = Message::where('id', $message);
        return $message->delete();
    }


    /**
     * Получает все сообщения в комнате
     *
     * @param $room_id
     * @return mixed
     */
    public function getByRoom ($room_id) {
        $messages = \App\Message::with('user')->where('room_id', $room_id)->orderBy('updated_at', 'asc')->get();
        return $messages->reject(function ($message) {});
    }


    /**
     * @param Request $request
     * @return bool|string
     */
    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        $message = $request->message;
        $room = $request->room_id;
        if (!($user && $message && $room))
            return 'Ошибка в переданных полях';

        /*
         * пример джоба
         */
        /*
        $job = (new SendMessage($user, $room, $message))->delay(now()->addMinutes(10));
        dispatch($job);

        SendMessage::dispatch($user, $room, $message)
            ->delay(now()->addSeconds(20));
        */

        broadcast(new MessageSent($user, $room, $message))->toOthers();

        return true;
    }
}
