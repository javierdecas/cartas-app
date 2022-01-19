<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    Route::put('/crear', [UsuariosController::class, 'crear']);
    Route::post('/login', [UsuariosController::class, 'login']);
    Route::post('/recuperarPassword', [UsuariosController::class, 'recuperarPassword']);
});
Route::prefix('cartas')->group(function()
{
    Route::put('/crear', [CartasController::class, 'crear']); //Solo admin
});
Route::prefix('colecciones')->group(function()
{
    Route::put('/crear', [ColeccionesController::class, 'crear']); //Solo admin
});
Route::prefix('ventas')->group(function()
{
    Route::put('/crear', [ColeccionesController::class, 'crear']); //Solo admin
});
Route::prefix('busquedas')->group(function()
{
    Route::get('/profesional', [ColeccionesController::class, 'crear']); //Solo profesionales y particulares
    Route::get('/', [ColeccionesController::class, 'crear']);
});