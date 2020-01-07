<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        $messages = \App\Message::where('id', '>', 0)->orderBy('updated_at', 'desc')->get();
        return $messages->reject(function () {});
        /*return [
            'type'       => 'message',
            'id'         => (string)$this->id,
            'created_at'         => (string)$this->created_at,
            'updated_at'         => (string)$this->updated_at,
            'room_id'       => $this->room_id,
            'user_id'       => $this->user_id,
            'text'       => (string)$this->text
        ];*/
    }
}
