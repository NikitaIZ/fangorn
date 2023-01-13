<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\TestController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\CCTV\CisternsController;

use App\Http\Controllers\Audit\XmlController;
use App\Http\Controllers\Audit\MenuController;
use App\Http\Controllers\Audit\PlateController;
use App\Http\Controllers\Audit\DolarController;
use App\Http\Controllers\Audit\BuffetController;
use App\Http\Controllers\Audit\RestaurantController;

use App\Http\Controllers\Maintenance\TankController;
use App\Http\Controllers\Marketings\HotelsController;
use App\Http\Controllers\Users\UserController;

use App\Http\Controllers\Roles\RoleController;

use App\Http\Controllers\Permissions\PermissionController;

use App\Http\Controllers\Reserves\DinnersController;
use App\Http\Controllers\Reserves\RevenueManagerController;

use App\Http\Controllers\Marketings\MarketingController;
use App\Http\Controllers\Marketings\ReportMarketingController;
use App\Http\Controllers\Marketings\MarketingDataController;
use App\Http\Controllers\Security\PersonalController;
use App\Http\Controllers\Security\AreaController;
use App\Http\Controllers\Security\PositionController;
use App\Http\Controllers\Security\PersonalIOLog;
use App\Http\Controllers\Security\PersonalWarn;
use App\Http\Controllers\Security\QrScanner;
use App\Http\Controllers\Security\QRController;

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

Route::get ('dashboard', [HomeController::class, 'index'])->name('dashboard');
Route::post('dashboard', [HomeController::class, 'store'])->name('dashboard.store');

/** Paginas para registrar **/

Route::get ('register', [RegisterController::class, 'index']) ->middleware('can:register.index') ->name('register.index');
Route::post('register', [RegisterController::class, 'create'])->middleware('can:register.create')->name('register.create');

/** Paginas de Perfil de Usuario **/

Route::prefix("profile")->group(function(){
    Route::name("profile.")->group(function(){
        //Route::get   ('profile',               [ProfileController::class, 'index'])              ->name('profile.index');
        //Route::post  ('profile',               [ProfileController::class, 'update'])             ->name('profile.update');
        //Route::post  ('profile/password',      [ProfileController::class, 'updatePassword'])     ->name('password.update');
        //Route::post  ('profile/authenticator', [ProfileController::class, 'updateAuthenticator'])->name('authenticator.update');
        //Route::delete('profile',               [ProfileController::class, 'deleteProfilePhoto']) ->name('profile-photo.delete');
    });
});

/** Paginas del Departamento Auditoria **/

Route::prefix("audit")->group(function(){
    Route::name("audit.")->group(function(){
        Route::get('/dolars',  [DolarController::class, 'index']) ->name('dolars.index');
        Route::get('/buffets', [BuffetController::class, 'index'])->name('buffets.index');
        Route::prefix("reports")->group(function(){
            Route::name("reports.")->group(function(){
                Route::get('/reports',      [XmlController::class, 'index'])->name('index');
                Route::get('/reports/{id}', [XmlController::class, 'show']) ->name('show');
            });
        });
        Route::prefix("restaurants")->group(function(){
            Route::name("restaurants.")->group(function(){
                Route::get('/',                   [RestaurantController::class, 'index'])->name('index');
                Route::get('/{lang}/{id}',        [MenuController::class, 'index'])      ->name('menus.index');
                Route::get('/{lang}/{rest}/{id}', [PlateController::class, 'index'])     ->name('plates.index');
            });
        });
    });
});

/** Paginas del Departamento Mantenimiento **/

Route::prefix("maintenance")->group(function(){
    Route::name("maintenance.")->group(function(){
        Route::get('/tanks',  [TankController::class, 'index'])->name('tanks.index');
    });
});

/** Paginas del Departamento CCTV **/

Route::prefix("cctv")->group(function(){
    Route::name("cctv.")->group(function(){
        Route::get('/cisterns',  [CisternsController::class, 'index'])->name('cisterns.index');
    });
});

/** Paginas del Departamento Reservas y Eventos **/

Route::prefix("reserves")->group(function(){
    Route::name("reserves.")->group(function(){
        Route::get('/revenue_manager',  [RevenueManagerController::class, 'index'])->name('manager.index');
        Route::post('/revenue_manager', [RevenueManagerController::class, 'store'])->name('manager.store');
        Route::prefix("dinners")->group(function(){
            Route::name("dinners.")->group(function(){
                Route::get('/',          [DinnersController::class, 'index'])    ->name('index');
                Route::get('/christmas', [DinnersController::class, 'christmas'])->name('christmas');
                Route::get('/new-year',  [DinnersController::class, 'newYear'])  ->name('newYear');
            });
        });
    });
});

Route::prefix("marketing")->group(function(){
    Route::name("marketing.")->group(function(){
        Route::get('/',        [MarketingController::class, 'index'])      ->name('index');
        Route::get('/reports', [ReportMarketingController::class, 'index'])->name('reports.index');
        Route::get('/hotels',  [HotelsController::class, 'index'])         ->name('hotels.index');
        Route::get('/data',    [MarketingDataController::class, 'index'])  ->name('data.index');
    });
});

/** Role y Permisos **/ 

Route::get('users',       [UserController::class, 'index'])      ->name('users.index');
Route::get('roles',       [RoleController::class, 'index'])      ->name('roles.index');
Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');

/*Paginas del departamento de Seguridad. */

//Agrega el prefijo security a todas las rutas registradas.

Route::prefix("security")->group(function(){

    //agrega el prefijo security. a todos los nombres de las rutas.
    Route::name("security.")->group(function(){

        //vistas
        //Route::view("/personal","security/personal/index")->name("index");
        Route::get("/personal",[PersonalController::class,"index"])->name("index");

        Route::get("/personal/{personal_id}",[PersonalController::class,"show"])->name("personal.get");

        Route::name("personal.register.")->group(function(){
            Route::get("/register",[PersonalController::class,"store_view"])->name("get");
            Route::post("/register",[PersonalController::class,"store"])->name("post");
        });

        Route::name("personal.update.")->group(function(){
            Route::get("/update/{personal_id}",[PersonalController::class,"update_show"])->name("get");
            Route::post("/update/{personal_id}",[PersonalController::class,"update"])->name("post");
        });

        Route::name("personal.delete.")->group(function(){
            Route::get("/delete/{personal_id}",[PersonalController::class,"delete_show"])->name("get");
            Route::post("/delete/{personal_id}",[PersonalController::class,"delete"])->name("post");
        });

        Route::prefix("area")->group(function(){
            Route::name("area.")->group(function(){
                Route::get("/",[AreaController::class,"index"])->name("index");
            });
        });

        Route::prefix("position")->group(function(){
            Route::name("position.")->group(function(){
                Route::get("/",[PositionController::class,'index'])->name("index");
            });
        });

        Route::prefix("personal_io_log")->group(function(){
            Route::name("personal_io_log.")->group(function(){
                Route::name("register.")->group(function(){
                    Route::get("/register/{personal_id}",[PersonalIOLog::class,"store_view"])->name("get");
                    Route::post("/register/{personal_id}",[PersonalIOLog::class,"store"])->name("post");
                });
            });
        });

        Route::prefix("personal_warn")->group(function(){
            Route::name("personal_warn.")->group(function(){
                Route::name("register.")->group(function(){
                    Route::get("/register/{personal_id}",[PersonalWarn::class,"store_view"])->name("get");
                    Route::post("/register/{personal_id}",[PersonalWarn::class,"store"])->name("post");
                });
            });
        });

        Route::prefix("qrScanner")->group(function(){
            Route::name("qrScanner.")->group(function(){
                Route::get("/",[QRController::class,"index"])->name("index");
                Route::get("/QR/{encryptedData}",[QRController::class,"scan"])->name("get");
                Route::get("/QR/Download/{encryptedData}",[QRController::class,"downloadQrAsPng"])->name("download");
            });
        });
    });
});

/** Pagina de pruebas **/ 

Route::get('test', [TestController::class, 'index'])->name('test');

/** Pagina para limpiar cache **/ 

Route::get('/clear-cache', function () { 
    echo Artisan::call('schedule:run');
    echo Artisan::call('config:clear'); 
    echo Artisan::call('config:cache'); 
    echo Artisan::call('cache:clear'); 
    echo Artisan::call('route:clear'); 
});