<?php

namespace App\Http\Controllers;

use App\Dialog;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function show($id)
	{
		return 'user ' . $id;
	}

	public function loginForm(){
		$result = DB::select('select * from users');
		echo "<pre>";
		var_dump($result);
		echo "</pre>";
		return view('loginForm');
	}

	public function login ()
	{
		return 'brfbrtberrtb';
	}

	public function dialogs ($user_id) {
		$user = User::where(['id' => $user_id])->with('dialogs')->get()->toArray();
		$dialogs = $user[0]['dialogs'];
		foreach ($dialogs as $key=>$dialog) {
			$d = new Dialog();
			$dialog['type'] = 'dialog';
			$dialog['name'] = $d->find($dialog['id'])->users()->wherePivot('user_id', '!=', $user_id)->get()->toArray()[0]['name'];
			$dialog['image_src'] = '/assets/images/user-profile.png';
			$dialogs[$key] = $dialog;
		}
		return json_encode($dialogs, JSON_UNESCAPED_UNICODE);
	}
}
