<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ResponsableController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\CuentaPacienteController;
use App\Http\Controllers\TurnoController;
use App\Http\Controllers\HorarioController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::group(['middleware' => ['auth']], function(){
    Route::resource('roles', RolController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('empleados', EmpleadoController::class);
    Route::resource('responsables', ResponsableController::class);
    Route::resource('pacientes', PacienteController::class);
    Route::resource('habitaciones', HabitacionController::class);
    Route::resource('ingresos', IngresoController::class);
    Route::resource('cuentas', CuentaPacienteController::class);
    Route::resource('turnos', TurnoController::class);
    Route::resource('horarios', HorarioController::class);
});