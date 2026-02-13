<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\LivreController; 
use App\Http\Controllers\Admin\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Ga3 l-routes li khasshoum l-auth
Route::middleware('auth')->group(function () {
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Section
    Route::prefix('admin')->group(function () {
        // Livres (Resource katsawab index, create, store, edit, update, destroy)
        Route::resource('livres', LivreController::class);

        // Pages l-livre
        Route::get('livres/{livre}/pages/create', [PageController::class, 'create'])->name('pages.create');
        Route::get('admin/livres/{id}/pages', [PageController::class, 'index']);
        Route::post('admin/livres/{livre}/pages', [PageController::class, 'store'])->name('pages.store');

        Route::get('admin/livres/{livre}/edit', [LivreController::class, 'edit'])->name('livres.edit');
        Route::put('admin/livres/{livre}', [LivreController::class, 'update'])->name('livres.update');
        Route::delete('admin/livres/{livre}', [LivreController::class, 'destroy'])->name('livres.destroy');
    });
});

require __DIR__.'/auth.php';