<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OperatorsController;
use App\Http\Controllers\UnitsController;
use App\Http\Controllers\ProvidersController;
use App\Http\Controllers\ContainersController;
use App\Http\Controllers\RoutesController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ScaleController;
use App\Http\Controllers\SystemLog;

// https://dashboard.heroku.com/apps/devifegrac-intercambios/settings
// http://devifegrac-intercambios.herokuapp.com/login

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

/*
    htacces root anterior

    <IfModule mod_rewrite.c>
RewriteEngine on
RewriteCond %{REQUEST_URI} !^public
RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
*/


//Agrega automaticamente las rutas de autenticación a nuestro proyecto.
Auth::routes();

// Route::get('/', [HomeController::class, 'root'])->name('root');

//Rutas protegidas.
Route::middleware('auth')->group(function () {   

    Route::get('/admin', [HomeController::class, 'root'])->name('root');

    Route::prefix('operators')->group(function() {
        Route::get('/', [OperatorsController::class, 'index'])->middleware('can:operators.index')->name('operators.index');
        Route::post('/', [OperatorsController::class, 'store'])->middleware('can:operators.store')->name('operators.store');
        Route::get('/create', [OperatorsController::class, 'create'])->middleware('can:operators.create')->name('operators.create');
        Route::get('/{operator}', [OperatorsController::class, 'show'])->middleware('can:operators.show')->name('operators.show');
        Route::put('/{operator}', [OperatorsController::class, 'update'])->middleware('can:operators.update')->name('operators.update');
        Route::delete('/{operator}', [OperatorsController::class, 'destroy'])->middleware('can:operators.destroy')->name('operators.destroy');
        Route::get('/{operator}/edit', [OperatorsController::class, 'edit'])->middleware('can:operators.edit')->name('operators.edit');
        Route::post('/{operator}/{equipment}/payment', [OperatorsController::class, 'equipmentPay'])->middleware('can:operators.equipmentPay')->name('operators.equipmentPay');
    });

    Route::prefix('units')->group(function() {
        Route::get('/', [UnitsController::class, 'index'])->middleware('can:units.index')->name('units.index');
        Route::post('/', [UnitsController::class, 'store'])->middleware('can:units.store')->name('units.store');
        Route::get('/create', [UnitsController::class, 'create'])->middleware('can:units.create')->name('units.create');
        Route::get('/{unit}', [UnitsController::class, 'show'])->middleware('can:units.show')->name('units.show');
        Route::put('/{unit}', [UnitsController::class, 'update'])->middleware('can:units.update')->name('units.update');
        Route::delete('/{unit}', [UnitsController::class, 'destroy'])->middleware('can:units.destroy')->name('units.destroy');
        Route::get('/{unit}/edit', [UnitsController::class, 'edit'])->middleware('can:units.edit')->name('units.edit');
    });

    Route::prefix('providers')->group(function() {
        Route::get('/', [ProvidersController::class, 'index'])->middleware('can:providers.index')->name('providers.index');
        Route::post('/', [ProvidersController::class, 'store'])->middleware('can:providers.store')->name('providers.store');
        Route::get('/create', [ProvidersController::class, 'create'])->middleware('can:providers.create')->name('providers.create');
        Route::get('/{provider}', [ProvidersController::class, 'show'])->middleware('can:providers.show')->name('providers.show');
        Route::put('/{provider}', [ProvidersController::class, 'update'])->middleware('can:providers.update')->name('providers.update');
        Route::delete('/{provider}', [ProvidersController::class, 'destroy'])->middleware('can:providers.destroy')->name('providers.destroy');
        Route::get('/{provider}/edit', [ProvidersController::class, 'edit'])->middleware('can:providers.edit')->name('providers.edit');
    });
    
    Route::prefix('containers')->group(function() {
        Route::get('/', [ContainersController::class, 'index'])->middleware('can:containers.index')->name('containers.index');
        Route::post('/', [ContainersController::class, 'store'])->middleware('can:containers.store')->name('containers.store');
        Route::get('/create', [ContainersController::class, 'create'])->middleware('can:containers.create')->name('containers.create');
        Route::get('/{container}', [ContainersController::class, 'show'])->middleware('can:containers.show')->name('containers.show');
        Route::put('/{container}', [ContainersController::class, 'update'])->middleware('can:containers.update')->name('containers.update');
        Route::delete('/{container}', [ContainersController::class, 'destroy'])->middleware('can:containers.destroy')->name('containers.destroy');
        Route::get('/{container}/edit', [ContainersController::class, 'edit'])->middleware('can:containers.edit')->name('containers.edit');
    });

    Route::prefix('routes')->group(function() {
        Route::get('/', [RoutesController::class, 'index'])->middleware('can:routes.index')->name('routes.index');
        Route::post('/', [RoutesController::class, 'store'])->middleware('can:routes.store')->name('routes.store');
        Route::get('/create', [RoutesController::class, 'create'])->middleware('can:routes.create')->name('routes.create');
        Route::get('/{route}', [RoutesController::class, 'show'])->middleware('can:routes.show')->name('routes.show');
        Route::put('/{route}', [RoutesController::class, 'update'])->middleware('can:routes.update')->name('routes.update');
        Route::delete('/{route}', [RoutesController::class, 'destroy'])->middleware('can:routes.destroy')->name('routes.destroy');
        Route::get('/{route}/edit', [RoutesController::class, 'edit'])->middleware('can:routes.edit')->name('routes.edit');
        Route::get('/{invoice}/invoice', [RoutesController::class, 'showInvoice'])->middleware('can:routes.showInvoice')->name('routes.showInvoice'); 
        Route::get('/{route}/scale/{endRoute?}', [RoutesController::class, 'createScale'])->middleware('can:routes.createScale')->name('routes.createScale'); 
        Route::post('/{route}/scale/', [RoutesController::class, 'storeScale'])->middleware('can:routes.storeScale')->name('routes.storeScale');
        Route::post('/{route}/endRoute', [RoutesController::class, 'endRoute'])->middleware('can:routes.endRoute')->name('routes.endRoute'); 
    });

    Route::prefix('equipment')->group(function() {
        Route::get('/', [EquipmentController::class, 'index'])->middleware('can:equipment.index')->name('equipment.index');
        Route::post('/', [EquipmentController::class, 'store'])->middleware('can:equipment.store')->name('equipment.store');
        Route::get('/create', [EquipmentController::class, 'create'])->middleware('can:equipment.create')->name('equipment.create');
        Route::get('/{equipment}', [EquipmentController::class, 'show'])->middleware('can:equipment.show')->name('equipment.show');
        Route::put('/{equipment}', [EquipmentController::class, 'update'])->middleware('can:equipment.update')->name('equipment.update');
        Route::delete('/{equipment}', [EquipmentController::class, 'destroy'])->middleware('can:equipment.destroy')->name('equipment.destroy');
        Route::get('/{equipment}/edit', [EquipmentController::class, 'edit'])->middleware('can:equipment.edit')->name('equipment.edit');
    });

    Route::prefix('users')->group(function() {
        Route::get('/', [UsersController::class, 'index'])->middleware('can:users.index')->name('users.index');
        Route::post('/', [UsersController::class, 'store'])->middleware('can:users.store')->name('users.store');
        Route::get('/create', [UsersController::class, 'create'])->middleware('can:users.create')->name('users.create');
        Route::get('/{user}', [UsersController::class, 'show'])->middleware('can:users.show')->name('users.show');
        Route::put('/{user}', [UsersController::class, 'update'])->middleware('can:users.update')->name('users.update');
        Route::delete('/{user}', [UsersController::class, 'destroy'])->middleware('can:users.destroy')->name('users.destroy');
        Route::get('/{user}/edit', [UsersController::class, 'edit'])->middleware('can:users.edit')->name('users.edit');
    });

    Route::prefix('roles')->group(function () {
        Route::get('/', [RolesController::class, 'index'])->middleware('can:roles.index')->name('roles.index');
        Route::get('/permissions', [RolesController::class, 'permissionsList'])->middleware('can:roles.permissionsList')->name('roles.permissionsList');
        Route::get('/create', [RolesController::class, 'create'])->middleware('can:roles.create')->name('roles.create');
        Route::post('/store', [RolesController::class, 'store'])->middleware('can:roles.store')->name('roles.store');
        Route::get('/{role}/edit', [RolesController::class, 'edit'])->middleware('can:roles.edit')->name('roles.edit');
        Route::put('/{role}', [RolesController::class, 'update'])->middleware('can:roles.update')->name('roles.update');
        Route::delete('/{role}/delete', [RolesController::class, 'destroy'])->middleware('can:roles.destroy')->name('roles.destroy');
    });

    Route::prefix('logs')->group(function() {
        Route::get('/', [SystemLog::class, 'index'])->middleware('can:logs.index')->name('logs.index');
    });
});


//Update User Details
Route::post('/update-profile/{id}', [HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [HomeController::class, 'updatePassword'])->name('updatePassword');


Route::get('{any}', [HomeController::class, 'index'])->name('index');


//Language Translation
Route::get('index/{locale}', [HomeController::class, 'lang']);
