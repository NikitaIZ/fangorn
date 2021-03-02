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

Route::get('/', function () { return redirect('login'); });

Route::get('contac-us', function () {
    $correo = new ContactUsMailable;
    Mail::to('michelle6yalaupari@gmail.com')->send($correo);
});

Route::middleware(['auth:sanctum', 'verified'])->get('tanks', 
    [TankController::class, 'index'])->name('tanks.index');

Route::middleware(['auth:sanctum', 'verified'])->get('tanks/create', 
    [TankController::class, 'createTank'])->name('tanks.create');

Route::middleware(['auth:sanctum', 'verified'])->post('tanks/create', 
    [TankController::class, 'updateTank'])->name('tanks.update');

Route::middleware(['auth:sanctum', 'verified'])->get('reports/create', 
    [TankController::class, 'createReport'])->name('reports.create');

Route::middleware(['auth:sanctum', 'verified'])->post('reports/create', 
    [TankController::class, 'updateReport'])->name('reports.update');

Route::middleware(['auth:sanctum', 'verified'])->get('tanks/{tank}', 
    [TankController::class, 'show'])->name('tanks.show');

Route::middleware(['auth:sanctum', 'verified'])->get('dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('register', function () {
    return view('auth.register');
})->name('register');

Route::middleware(['auth:sanctum', 'verified'])->get('CCTV', function () {
    return view('welcome');
})->name('cctv');




