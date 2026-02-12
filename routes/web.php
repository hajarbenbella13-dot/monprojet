<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\LivreController; // S7i7a
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Had l-blassa hya li ghadi t-dkhel liha mwra l-login (ila beddelty HOME f RouteServiceProvider)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // N-diro l-prefix hna bach t-khdem /admin/livres
    Route::prefix('admin')->group(function () {
        Route::resource('livres', LivreController::class);
    });
});

// Hiyyedna Route::get('/login') hit auth.php (Breeze) dayra l-khedma dyalha
require __DIR__.'/auth.php';