<?php

use App\Http\Controllers\CitaController;
use App\Http\Controllers\ClinicaController;
use App\Http\Controllers\MascotaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API CLIENTES
Route::controller(ClienteController::class)->prefix('clientes')->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::post('/{id}', 'update');
    Route::put('/{id}', 'put');
    Route::get('/{id}', 'show');
    Route::delete('/{id}', 'destroy');
});

// API MASCOTAS
Route::controller(MascotaController::class)->prefix('mascotas')->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::post('/{id}', 'update');
    Route::put('/{id}', 'put');
    Route::get('/{id}', 'show');
    Route::delete('/{id}', 'destroy');
}); 

// RUTAS CITA
Route::controller(CitaController::class)->prefix('citas')->group(function () {
    Route::get('/', 'getAll');
    Route::get('/{id}', 'getById');
    Route::post('/new', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
    Route::get('/mascota/{num_chip}', 'getCitasMascota');
    Route::get('/clinica/{id_clinica}', 'getCitasClinica');
    Route::get('/{hora}/{fecha}', 'getCitaHoraYFecha');
}); 


// RUTAS CLINICA
Route::controller(ClinicaController::class)->prefix('clinicas')->group(function () {
    Route::get('/', 'getAll');
    Route::get('/{id}', 'getById');
    Route::post('/new', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
}); 


