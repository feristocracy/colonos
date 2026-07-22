<?php

use App\Http\Controllers\ColonoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TesoreriaController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\ProyectoCotizacionConceptoController;
use App\Http\Controllers\ProyectoCotizacionController;

Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'admin'])->name('admin');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Tesoreria
Route::middleware(['auth'])->group(function () {
    Route::get('/tesoreria', [TesoreriaController::class, 'index'])->name('tesoreria.index');
    Route::get('/tesoreria/print', [TesoreriaController::class, 'print'])->name('tesoreria.print');
    Route::get('/tesoreria/historico', [TesoreriaController::class, 'historico'])->name('tesoreria.historico');
});

Route::middleware(['auth', 'tesorero'])->group(function () {
    Route::post('/tesoreria', [TesoreriaController::class, 'store'])->name('tesoreria.store');
});

//Colonos
Route::middleware(['auth'])->group(function () {
    Route::get('/pagos', [PagoController::class, 'index'])->name('pagos.index');
    Route::get('/colonos', [ColonoController::class, 'index'])->name('colonos.index');
    Route::get('/colonos/{colono}', [ColonoController::class, 'show'])->name('colonos.show');
    Route::get('/colonos/{colono}/estado-cuenta/pdf', [ColonoController::class, 'estadoCuentaPdf'])
        ->name('colonos.estado-cuenta.pdf');
    Route::post('/colonos/{colono}/pagos', [PagoController::class, 'store'])
    ->middleware('role:tesorero')
    ->name('colonos.pagos.store');
    Route::get('/colonos/{colono}/edit', [ColonoController::class, 'edit'])->name('colonos.edit');
    Route::put('/colonos/{colono}', [ColonoController::class, 'update'])->name('colonos.update');
    Route::delete('/colonos/{colono}', [ColonoController::class, 'destroy'])->name('colonos.destroy');
    //Proyectos
    Route::resource('proyectos', ProyectoController::class)
        ->only([
            'index',
            'create',
            'store',
            'show',
        ]);

    Route::post(
        '/proyectos/{proyecto}/lideres',
        [ProyectoController::class, 'agregarLider']
    )->name('proyectos.lideres.store');

    Route::post('/proyectos/{proyecto}/movimientos', [ProyectoController::class, 'registrarMovimiento'])
    ->name('proyectos.movimientos.store');

    Route::delete(
        '/proyectos/{proyecto}/lideres/{usuario}',
        [ProyectoController::class, 'eliminarLider']
    )->name('proyectos.lideres.destroy');
});

Route::get('/colonos/{colono}', [ColonoController::class,'show'])
    ->middleware('auth')
    ->name('colonos.show');

Route::post('/colonos', [ColonoController::class, 'store'])
    ->middleware(['role:admin,tesorero'])
    ->name('colonos.store');    
    
/* Route::get('/colonos/{colono}/edit', [ColonoController::class, 'edit'])
    ->name('colonos.edit');

Route::delete('/colonos/{colono}', [ColonoController::class, 'destroy'])
    ->name('colonos.destroy'); */

//Usuarios
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

//Proyectos Cotizaciones
Route::post('proyectos/{proyecto}/cotizaciones', [ProyectoCotizacionConceptoController::class, 'store'])
    ->name('proyectos.cotizaciones.store');

Route::get('proyectos/{proyecto}/cotizaciones/{cotizacionConcepto}', [ProyectoCotizacionConceptoController::class, 'show'])
    ->name('proyectos.cotizaciones.show');

Route::post('proyectos/{proyecto}/cotizaciones/{cotizacionConcepto}/detalles', [ProyectoCotizacionController::class, 'store'])
    ->name('proyectos.cotizaciones.detalles.store');

Route::post('proyectos/{proyecto}/cotizaciones/{cotizacionConcepto}/detalles/{cotizacion}/archivos', [ProyectoCotizacionController::class, 'storeArchivos'])
    ->name('proyectos.cotizaciones.detalles.archivos.store');

Route::post('proyectos/{proyecto}/cotizaciones/{cotizacionConcepto}/detalles/{cotizacion}/comentarios', [ProyectoCotizacionController::class, 'storeComentario'])
    ->name('proyectos.cotizaciones.detalles.comentarios.store');

require __DIR__ . '/auth.php';
