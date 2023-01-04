<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Models\Security\PersonalModel;
use App\Http\Controllers\Security\PersonalController;

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

Route::get('/', function () { return redirect('login'); });

Route::get('/offline', function () { return view('/vendor/laravelpwa/offline'); });

Route::get('send-mail', function () {

    $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];

    Mail::to('michelle6yalaupari@gmail.com')->send(new \App\Mail\MyTestMail($details));

    dd("Email is Sent.");
});









Route::name("dinner")->group(function(){

    Route::view("/dinner","reserves/dinner/index");


});


