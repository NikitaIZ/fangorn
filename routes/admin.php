<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\TestController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Users\UserController;

use App\Http\Controllers\CCTV\CisternsController;

use App\Http\Controllers\Audit\XmlController;
use App\Http\Controllers\Audit\MenuController;
use App\Http\Controllers\Audit\PlateController;
use App\Http\Controllers\Audit\DolarController;
use App\Http\Controllers\Audit\BuffetController;
use App\Http\Controllers\Audit\RestaurantController;

use App\Http\Controllers\Maintenance\TankController;

use App\Http\Controllers\Roles\RoleController;
use App\Http\Controllers\Roles\RolePermissionController;

use App\Http\Controllers\Permissions\PermissionController;

use App\Http\Controllers\Reserves\dinnersController;
use App\Http\Controllers\Reserves\RevenueManagerController;

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

/** Pagina de inicio **/

Route::get ('dashboard',        [HomeController::class, 'index']) ->middleware('can:dashboard')->name('dashboard');
Route::post('dashboard',        [HomeController::class, 'store']) ->middleware('can:dashboard')->name('dashboard.store');
Route::get ('dashboard/update', [HomeController::class, 'update'])->middleware('can:dashboard')->name('dashboard.update');

/** Paginas para registrar **/

Route::get ('register', [RegisterController::class, 'index']) ->middleware('can:register.index') ->name('register.index');
Route::post('register', [RegisterController::class, 'create'])->middleware('can:register.create')->name('register.create');

/** Paginas de Perfil de Usuario **/

//Route::get   ('profile',               [ProfileController::class, 'index'])              ->name('profile.index');
//Route::post  ('profile',               [ProfileController::class, 'update'])             ->name('profile.update');
//Route::post  ('profile/password',      [ProfileController::class, 'updatePassword'])     ->name('password.update');
//Route::post  ('profile/authenticator', [ProfileController::class, 'updateAuthenticator'])->name('authenticator.update');
//Route::delete('profile',               [ProfileController::class, 'deleteProfilePhoto']) ->name('profile-photo.delete');

/** Paginas del Departamento Auditoria **/
Route::get('audit/dolars', [DolarController::class, 'index'])->name('audit.dolars.index');

Route::get('audit/buffets', [BuffetController::class, 'index'])->name('audit.buffets.index');

Route::get('audit/reports',        [XmlController::class, 'index'])->name('audit.reports.index');
Route::get('audit/reports/{id}',   [XmlController::class, 'show']) ->name('audit.reports.show');

Route::get('audit/restaurants',                    [RestaurantController::class, 'index'])->name('audit.restaurants.index');
Route::get('audit/restaurants/{lang}/{id}',        [MenuController::class, 'index'])      ->name('audit.menus.index');
Route::get('audit/restaurants/{lang}/{rest}/{id}', [PlateController::class, 'index'])     ->name('audit.plates.index');

/** Paginas del Departamento Mantenimiento **/

Route::resource('tanks', TankController::class);

/** Paginas del Departamento CCTV **/

Route::resource('cctv/cisterns', CisternsController::class)->names([
                                                                        'index'   => 'cctv.cisterns.index',
                                                                        'create'  => 'cctv.cisterns.create',
                                                                        'store'   => 'cctv.cisterns.store',
                                                                        'destroy' => 'cctv.cisterns.destroy',
                                                                        'update'  => 'cctv.cisterns.update',
                                                                        'edit'    => 'cctv.cisterns.edit',
                                                                        'show'    => 'cctv.cisterns.show'
                                                                    ]);

/** Paginas del Departamento Reservas y Eventos **/
Route::get('reserves/revenue_manager',  [RevenueManagerController::class, 'index'])->middleware('can:revenue_manager.index')->name('reserves.manager.index');
Route::post('reserves/revenue_manager', [RevenueManagerController::class, 'store'])->middleware('can:revenue_manager.index')->name('reserves.manager.store');

Route::get('reserves/dinners',           [dinnersController::class, 'index'])    ->middleware('can:test')->name('reserves.dinners.index');
Route::get('reserves/dinners/christmas', [dinnersController::class, 'christmas'])->middleware('can:test')->name('reserves.dinners.christmas');
Route::get('reserves/dinners/new-year',  [dinnersController::class, 'newYear'])  ->middleware('can:test')->name('reserves.dinners.newYear');

/** Role y Permisos **/ 

Route::resource('users', UserController::class);

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

/** Pagina de pruebas **/ 

Route::get('test',  [TestController::class, 'index'])->middleware('can:test')->name('test');
Route::get('test/{month}', [TestController::class, 'show'])->middleware('can:test')->name('test.show');
Route::post('test', [TestController::class, 'store'])->middleware('can:test')->name('test1');

Route::get('/clear-cache', function () { 
    echo Artisan::call('schedule:run');
    echo Artisan::call('config:clear'); 
    echo Artisan::call('config:cache'); 
    echo Artisan::call('cache:clear'); 
    echo Artisan::call('route:clear'); 
});