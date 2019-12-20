<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');
Artisan::command('time', function () {
    echo "\n" . 'Hi!' . "\n" . 'Now in ' . ini_get('date.timezone') . ' ';
    echo (date("H")+3) . date(":i:s") . "\n";   // windows must die
})->describe('Showing current time and server timezone.');
