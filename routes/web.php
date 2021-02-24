<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TankController;

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

Route::get('/', function () {
    return redirect('login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/tanks', [TankController::class, 'index'])->name('tanks');

Route::middleware(['auth:sanctum', 'verified'])->get('/tanks/create', [TankController::class, 'create']);

Route::middleware(['auth:sanctum', 'verified'])->get('/tanks/{tank}', [TankController::class, 'show']);

Route::middleware(['auth:sanctum', 'verified'])->get('/CCTV', function () {
    return view('welcome');
})->name('cctv');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('contac-us', function () {
    $correo = new ContactUsMailable;
    Mail::to('michelle6yalaupari@gmail.com')->send($correo);
});
