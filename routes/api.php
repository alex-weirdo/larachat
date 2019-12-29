<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// комнаты чата
Route::resource('/rooms', 'RoomController');
Route::get('/rooms/', function(){
    $rooms = \App\Room::where('id', '>', 0)->orderBy('updated_at', 'desc')->get();
    return $rooms->reject(function ($room) {
        $room->isActive = false;
    });
});

// сообщения
Route::get('/messages/{room_id}', function($room_id){
    $messages = \App\Message::where('room_id', $room_id)->orderBy('updated_at', 'asc')->get();
    return $messages->reject(function ($message) {});
});