<?php

use App\Http\Controllers\BuffetController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


use App\Http\Controllers\HomeController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\XmlController;
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


//Rutas de los Tanques
Route::middleware(['auth:sanctum', 'verified'])->get('tanks', 
                                                    [TankController::class, 'index']
                                                    )->name('tanks.index');

Route::middleware(['auth:sanctum', 'verified'])->get('tanks/create', 
                                                    [TankController::class, 'createTank']
                                                    )->name('tanks.create');

Route::middleware(['auth:sanctum', 'verified'])->post('tanks/create', 
                                                    [TankController::class, 'updateTank']
                                                    )->name('tanks.update');

Route::middleware(['auth:sanctum', 'verified'])->get('tanks/reports/create', 
                                                    [TankController::class, 'createReport']
                                                    )->name('tanks.reports.create');

Route::middleware(['auth:sanctum', 'verified'])->post('tanks/reports/create', 
                                                    [TankController::class, 'updateReport']
                                                    )->name('tanks.reports.update');

Route::middleware(['auth:sanctum', 'verified'])->get('tanks/{tank}', 
                                                    [TankController::class, 'show']
                                                    )->name('tanks.show');

//Rutas de inicio

Route::middleware(['auth:sanctum', 'verified'])->get('dashboard', 
                                                    [HomeController::class, 'index']
                                                    )->name('dashboard');

Route::get('register', function () { return view('auth.register'); })->name('register');

Route::middleware(['auth:sanctum', 'verified'])->get('CCTV', 
                                                    function () {
                                                    return view('welcome');
                                                    })->name('cctv');

//Ruta xml

Route::middleware(['auth:sanctum', 'verified'])->get('xmls', 
                                                    [XmlController::class, 'index']
                                                    )->name('xml.index');

Route::middleware(['auth:sanctum', 'verified'])->get('xmls/create', 
                                                    [XmlController::class, 'createXml']
                                                    )->name('xml.create');

Route::middleware(['auth:sanctum', 'verified'])->get('xmls/{xml}', 
                                                    [XmlController::class, 'show']
                                                    )->name('xmls.show');

//Buffet

Route::middleware(['auth:sanctum', 'verified'])->get('buffet',
                                                    [BuffetController::class, 'index']
                                                    )->name('buffet');

Route::middleware(['auth:sanctum', 'verified'])->put('buffet',
                                                    [BuffetController::class, 'update']
                                                    )->name('buffet.update');
