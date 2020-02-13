<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dialog extends Model
{
	protected $table = 'dialogs';

    public function users () {
		return $this->belongsToMany(User::class, 'users_dialogs');
	}
}
