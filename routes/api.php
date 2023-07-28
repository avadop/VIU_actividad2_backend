<?php

use App\Http\Controllers\CitaController;
use App\Http\Controllers\ClinicaController;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\RecordatorioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\AlertaController;
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
    Route::get('/', 'getAll');
    Route::get('/{id}', 'getById');
    Route::get('/{id}/mascotas', 'getMascotas');
    Route::post('/new', 'create');
    Route::put('/{id}', 'update');
    Route::patch('/{id}', 'patch');
    Route::delete('/{id}', 'delete');
    Route::get('/log-in/{dni}/{password}', 'logIn');
    Route::get('/advance/search', 'search'); 
});

// API MASCOTAS
Route::controller(MascotaController::class)->prefix('mascotas')->group(function () {
    Route::get('/', 'getAll');
    Route::get('/{id}', 'getById');
    Route::get('/{id}/cliente', 'getCliente');
    Route::get('/advance/search', 'search'); 
    Route::post('/new', 'create');
    Route::put('/{id}', 'update');
    Route::patch('/{id}', 'patch');
    Route::delete('/{id}', 'delete');
}); 

// RUTAS CITA
Route::controller(CitaController::class)->prefix('citas')->group(function () {
    Route::get('/', 'getAll');
    Route::get('/{id}', 'getById');
    Route::get('/advance/search', 'search'); 
    Route::post('/new', 'create');
    Route::put('/{id}', 'update');
    Route::patch('/{id}', 'patch');
    Route::delete('/{id}', 'delete');
    Route::get('/mascota/{num_chip}', 'getCitasMascota');
    Route::get('/clinica/{id_clinica}', 'getCitasClinica');
    Route::get('/{hora}/{fecha}', 'getCitaHoraYFecha');
}); 


// RUTAS CLINICA
Route::controller(ClinicaController::class)->prefix('clinicas')->group(function () {
    Route::get('/', 'getAll');
    Route::get('/{id}', 'getById');
    Route::get('/advance/search', 'search'); 
    Route::post('/new', 'create');
    Route::put('/{id}', 'update');
    Route::patch('/{id}', 'patch');
    Route::delete('/{id}', 'delete');
}); 

// RUTAS RECORDATORIOS
Route::controller(RecordatorioController::class)->prefix('recordatorios')->group(function () {
    Route::get('/', 'getAll');
    Route::get('/{id}', 'getById');
    Route::post('/new', 'create');
    Route::put('/{id}', 'update');
    Route::patch('/{id}', 'patch');
    Route::delete('/{id}', 'delete');
    Route::get('/mascota/{num_chip}', 'getRecordatoriosMascota');
    Route::get('/clinica/{id_clinica}', 'getRecordatoriosClinica');
    Route::get('/advance/search', 'search'); 
});

//RUTAS PRODUCTOS
Route::controller(ProductoController::class)->prefix('productos')->group(function () {
    Route::get('/', 'getAll');
    Route::get('/{id}', 'getById');
    Route::post('/new', 'create');
    Route::put('/{id}', 'update');
    Route::patch('/{id}', 'patch');
    Route::delete('/{id}', 'delete');
    Route::get('/nombre_producto/{nombre_}', 'getProductosNombre');
    Route::get('/advance/search', 'search'); 
   
});

//RUTAS COMPRAS
Route::controller(CompraController::class)->prefix('compras')->group(function () {
    Route::get('/', 'getAll');
    Route::get('/advance/search', 'search'); 
    Route::get('/{id_producto}/{dni}', 'getById');
    Route::post('/new', 'create');
    Route::put('/{id_producto}/{dni}', 'update');
    Route::patch('/{id_producto}/{dni}', 'patch');
    Route::delete('/{id_producto}/{dni}', 'delete');
    Route::get('/cliente/dni/{dni}', 'getComprasDNI');
   
});

//RUTAS ALERTAS
Route::controller(AlertaController::class)->prefix('alertas')->group(function () {
    Route::get('/', 'getAll');
    Route::get('/{id}', 'getById');
    Route::post('/new', 'create');
    Route::put('/{id}', 'update');
    Route::patch('/{id}', 'patch');
    Route::delete('/{id}', 'delete');
    Route::get('/id_producto/{id_producto}', 'getAlertasProducto');
    Route::get('/advance/search', 'search'); 
}); 