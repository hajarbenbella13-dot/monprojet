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
    Route::prefix('admin')->middleware('auth')->group(function () {

        // Livres
        Route::resource('livres', LivreController::class);
    
        // Pages
        Route::get('livres/{livre}/pages/create', [PageController::class, 'create'])->name('pages.create');
    
        // Inline edit → route update
        Route::get('admin/livres/{livre}/pages/create', [PageController::class, 'create'])->name('pages.create');
    
        // Store new page
        Route::post('livres/{livre}/pages', [PageController::class, 'store'])->name('pages.store');
    
        // Show page
        Route::get('pages/{page}', [PageController::class, 'show'])->name('pages.show');
    
        // Edit page page (si tu veux séparé)
        Route::get('pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
    
        // Delete page
        Route::delete('pages/{page}', [PageController::class, 'destroy'])->name('pages.destroy');
        Route::get('pages/{page}/edit', [PageController::class, 'create'])->name('pages.edit'); // bhal create + edit
        Route::put('pages/{page}', [PageController::class, 'update'])->name('pages.update');
        Route::get('admin/livres/{livre}/pages', [PageController::class, 'index'])->name('pages.index');

    
    });
    
});

require __DIR__.'/auth.php';

