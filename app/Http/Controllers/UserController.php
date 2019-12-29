<?php

namespace App\Http\Controllers;

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
}
