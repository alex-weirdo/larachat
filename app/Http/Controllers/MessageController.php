<?php

namespace App\Http\Controllers;

use App\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\MockObject\Stub\Exception;
use Symfony\Component\Console\Output\ConsoleOutput;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function destroy(Message $message)
    {
        //
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


    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        $message = $request->message;
        $room = $request->room_id;
        if (!($user && $message && $room))
            return 'Ошибка в переданных полях';
        broadcast(new MessageSent($user, $room, $message))->toOthers();
    }
}
