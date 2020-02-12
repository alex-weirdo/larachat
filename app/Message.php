<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $primaryKey = 'room_id';

    public function user () {
        return $this->hasOne('\App\User', 'id', 'user_id');
    }
}
