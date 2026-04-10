<?php

use App\Http\Controllers\ColonoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TesoreriaController;
use Illuminate\Support\Facades\Route;

Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'admin'])->name('admin');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Tesoreria
Route::middleware(['auth'])->group(function () {
    Route::get('/tesoreria', [TesoreriaController::class, 'index'])->name('tesoreria.index');
    Route::get('/tesoreria/print', [TesoreriaController::class, 'print'])->name('tesoreria.print');
});

Route::middleware(['auth', 'tesorero'])->group(function () {
    Route::post('/tesoreria', [TesoreriaController::class, 'store'])->name('tesoreria.store');
});

//Colonos
Route::middleware(['auth'])->group(function () {
    Route::get('/pagos', [PagoController::class, 'index'])->name('pagos.index');
    Route::get('/colonos', [ColonoController::class, 'index'])->name('colonos.index');
    Route::post('/colonos', [ColonoController::class, 'store'])->name('colonos.store');
    Route::get('/colonos/{colono}', [ColonoController::class, 'show'])->name('colonos.show');
    Route::get('/colonos/{colono}/estado-cuenta/pdf', [ColonoController::class, 'estadoCuentaPdf'])
        ->name('colonos.estado-cuenta.pdf');
    Route::post('/colonos/{colono}/pagos', [PagoController::class, 'store'])
    ->middleware('role:tesorero')
    ->name('colonos.pagos.store');
});

Route::get('/colonos/{colono}', [ColonoController::class,'show'])
    ->middleware('auth')
    ->name('colonos.show');

Route::get('/colonos/{colono}/edit', [ColonoController::class, 'edit'])
    ->name('colonos.edit');

Route::delete('/colonos/{colono}', [ColonoController::class, 'destroy'])
    ->name('colonos.destroy');

//Usuarios
Route::middleware(['auth'])->group(function () {
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');

    Route::post('/usuarios', [UserController::class, 'store'])
        ->middleware('role:admin')
        ->name('usuarios.store');

    Route::delete('/usuarios/{user}', [UserController::class, 'destroy'])
        ->middleware('role:admin')
        ->name('usuarios.destroy');
});

require __DIR__ . '/auth.php';
