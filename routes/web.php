<?php

use Illuminate\Support\Facades\Route;

use App\Mail\ContactUsMailable;
use Illuminate\Support\Facades\Mail;
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

Route::get('contac-us', function () {
    $correo = new ContactUsMailable;
    Mail::to('michelle6yalaupari@gmail.com')->send($correo);
});