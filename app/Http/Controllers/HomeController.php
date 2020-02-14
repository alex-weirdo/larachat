<?php

namespace App\Http\Controllers;

use App\Dialog;
use App\Message;
use App\Permission;
use App\Policies\MessagesPolicy;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{
    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $user = User::find(2);

        

        # ПОЛИТИКИ

        # можно так:
        # $user->can('viewAny', Message::class)
        # или так:
        # Gate::denies('viewAny', Message::class)
        # еще так:
        # policy(Message::class)->viewAny($user)


        /* $result = $user->can('delete', MessagesPolicy::class);
        echo "<pre>";
        var_dump($result);
        echo "</pre>";
        die();*/

        /*
        $perm = Permission::where('slug', 'admin_section')->get();
        echo "<pre>";
        var_dump($perm->toArray());
        echo "</pre>";
        die();
        */

        /*
        $role = Role::where('slug', 'admin')->get();
        echo "<pre>";
        var_dump($role->toArray());
        echo "</pre>";
        die();
        */

        return view('home');
    }
}
