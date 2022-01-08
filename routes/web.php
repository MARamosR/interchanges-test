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


//Agrega automaticamente las rutas de autenticación a nuestro proyecto.
Auth::routes();

Route::get('/', [HomeController::class, 'root'])->name('root');

//Rutas protegidas.
Route::middleware('auth')->group(function () {
    
    Route::resource('operators', OperatorsController::class);
    Route::resource('units', UnitsController::class);
    Route::resource('providers', ProvidersController::class);
    Route::resource('containers', ContainersController::class);
    Route::resource('routes', RoutesController::class);
    Route::resource('equipment', EquipmentController::class);

    Route::prefix('roles')->group(function () {
        
        Route::get('/', [RolesController::class, 'index'])->name('roles.index');
        Route::get('/roles/permissions', [RolesController::class, 'permissionsList'])->name('roles.permissionsList');
        Route::get('/roles/create', [RolesController::class, 'create'])->name('roles.create');
        Route::get('/roles/create-user', [RolesController::class, 'createUser'])->name('roles.createUser');
    });
});


//Update User Details
Route::post('/update-profile/{id}', [HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [HomeController::class, 'updatePassword'])->name('updatePassword');


Route::get('{any}', [HomeController::class, 'index'])->name('index');


//Language Translation
Route::get('index/{locale}', [HomeController::class, 'lang']);
