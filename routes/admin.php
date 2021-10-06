<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\TestController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\XmlController;
use App\Http\Controllers\TankController;
use App\Http\Controllers\BuffetController;
use App\Http\Controllers\DolarController;

use App\Http\Controllers\Roles\RoleController;
use App\Http\Controllers\Roles\RolePermissionController;

use App\Http\Controllers\Permissions\PermissionController;


use App\Http\Controllers\Reports\ReportTankController;



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


Route::get('dashboard', [HomeController::class, 'index'])->middleware('can:dashboard')->name('dashboard');
Route::post('dashboard', [HomeController::class, 'store'])->middleware('can:dashboard')->name('dashboard.update');


Route::get('register', [RegisterController::class, 'index'])->middleware('can:register.index')->name('register.index');
Route::post('register', [RegisterController::class, 'create'])->middleware('can:register.create')->name('register.create');

Route::resource('xmls', XmlController::class);

Route::resource('buffet', BuffetController::class);

Route::resource('dolar', DolarController::class);

Route::resource('roles', RoleController::class);

Route::resource('roles/permissions', RolePermissionController::class)->names([
                                                                                'index'   => 'roles.permissions.index',
                                                                                'create'  => 'roles.permissions.create',
                                                                                'store'   => 'roles.permissions.store',
                                                                                'destroy' => 'roles.permissions.destroy',
                                                                                'update'  => 'roles.permissions.update',
                                                                                'edit'    => 'roles.permissions.edit',
                                                                                'show'    => 'roles.permissions.show'
                                                                            ]);

Route::resource('permissions', PermissionController::class);

Route::resource('tanks', TankController::class);

Route::resource('tanks/reports', ReportTankController::class)->names([
                                                                        'index'   => 'tanks.reports.index',
                                                                        'create'  => 'tanks.reports.create',
                                                                        'store'   => 'tanks.reports.store',
                                                                        'destroy' => 'tanks.reports.destroy',
                                                                        'update'  => 'tanks.reports.update',
                                                                        'edit'    => 'tanks.reports.edit',
                                                                        'show'    => 'tanks.reports.show'
                                                                    ]);

Route::get('test', [TestController::class, 'index'])->middleware('can:test')->name('test');
Route::post('test', [TestController::class, 'store'])->middleware('can:test')->name('test1');
