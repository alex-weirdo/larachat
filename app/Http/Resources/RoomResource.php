<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type'       => 'room',
            'id'         => (string)$this->id,
            'name'       => (string)$this->name,
            'attributes' => [
                'name'   => (string)$this->name,
                'last_update' => $this->updated_at,
                'img' => $this->image_src
            ],
        ];
    }
}
