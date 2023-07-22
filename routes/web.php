<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Rutas para la tabla de equipos 
Route::get('/equipos', [EquipmentController::class, 'index']);
Route::post('/equipos', [EquipmentController::class, 'store']);
Route::get('/equipos/{id}', [EquipmentController::class, 'show']);
Route::put('/equipos/{id}', [EquipmentController::class, 'update']);
Route::delete('/equipos/{id}', [EquipmentController::class, 'destroy']);

//Rutas para la tabla de asignaciones
Route::get('/asignaciones', [AssignmentController::class, 'index']);
Route::post('/asignaciones', [AssignmentController::class, 'store']);
Route::get('/asignaciones/{id}', [AssignmentController::class, 'show']);
Route::put('/asignaciones/{id}', [AssignmentController::class, 'update']);
Route::delete('/asignaciones/{id}', [AssignmentController::class, 'destroy']);
Route::get('/equipos', [AssignmentController::class, 'getEquipos']);
Route::get('/empleados', [AssignmentController::class, 'getEmpleados']);

//Rutas para la tabla de empleados
Route::get('/empleados', [EmployeeController::class, 'index']);
Route::post('/empleados', [EmployeeController::class, 'store']);
Route::get('/empleados/{id}', [EmployeeController::class, 'show']);
Route::put('/empleados/{id}', [EmployeeController::class, 'update']);
Route::delete('/empleados/{id}', [EmployeeController::class, 'destroy']);

