<?php

use App\Http\Controllers\ColonoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
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

//Colonos
Route::middleware(['auth'])->group(function () {
    Route::get('/colonos', [ColonoController::class, 'index'])->name('colonos.index');
    Route::post('/colonos', [ColonoController::class, 'store'])->name('colonos.store');
});

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
