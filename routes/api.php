<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// TODO: Implementar controladores tipo Rest.

// Rutas publicas
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

// Rutas protegidas
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/provider', function() {
        return 'providers';
    });
});


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return 'users';
// });
