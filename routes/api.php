<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CartasController;
use App\Http\Controllers\ColeccionsController;
use App\Http\Controllers\VentasController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('usuarios')->group(function()
{
    Route::put('/crear', [UsersController::class, 'crear']);
    Route::post('/login/{nombre_usuario}/{password}', [UsersController::class, 'login']);
    Route::post('/recuperarPassword/{email}', [UsersController::class, 'recuperarPassword']);
});
Route::prefix('cartas')->group(function()
{
    Route::put('/crear', [CartasController::class, 'crear']); //Solo admin
});
Route::prefix('colecciones')->group(function()
{
    Route::put('/crear', [ColeccionsController::class, 'crear']); //Solo admin
    Route::put('/crearyasignar', [ColeccionsController::class, 'crearyasignar']); //Solo admin
    Route::put('/asignar', [ColeccionsController::class, 'asignar']); //Solo admin
});
Route::prefix('ventas')->group(function()
{
    Route::put('/crear', [VentasController::class, 'crear']); //Solo admin
});
Route::prefix('busquedas')->group(function()
{
    Route::get('/profesional', [VentasController::class, 'crear']); //Solo profesionales y particulares
    Route::get('/', [VentasController::class, 'crear']);
});