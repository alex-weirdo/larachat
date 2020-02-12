<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/{id}', 'UserController@show')->middleware('auth');


Route::get('/login/', 'UserController@loginForm');
Route::post('/login/', [ 'as' => 'login', 'uses' => 'Auth\LoginController@do']);

Auth::routes();

Route::get('/test', function() {
    if (DB::connection()->getDatabaseName()) {
        dd('Есть контакт!');
    } else {
        return 'Соединения нет';
    }
})->middleware('auth');


Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//
Route::post('/messages', 'MessageController@sendMessage');