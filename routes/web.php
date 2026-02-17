<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\LivreController; 
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\LecteurController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// ============================================================
// 1. ROUTES PUBLIQUES (Bla Email/Password - Khassa b l-atfal)
// ============================================================

Route::get('/', function () {
    return view('welcome');
});

// Hadu huma l-ghalyin 3la l-weld:
Route::get('/admin/lecteurs/create', [LecteurController::class, 'create'])->name('lecteurs.create');
Route::post('/admin/lecteurs', [LecteurController::class, 'store'])->name('lecteurs.store');

// 🔥 HADI HIYA LI KANT NA9SA L-FOQ (Check PIN)
Route::post('/lecteurs/check-pin', [LecteurController::class, 'checkPin'])->name('lecteurs.checkPin');

Route::get('/exit-lecteur', function () {
    session()->forget(['active_lecteur_id', 'active_lecteur_nom']);
    return redirect()->route('lecteurs.create'); 
})->name('lecteur.exit');

// Routes dial l-qraya
Route::get('/lecteurs/{lecteur}', [LecteurController::class, 'show'])->name('lecteurs.show');
Route::get('/lecteurs/{lecteur}/livre/{livre}/continuer', [LecteurController::class, 'continuer'])->name('lecteur.continuer');
Route::get('/lecteurs/{lecteur}/livre/{livre}/read/{page?}', [LecteurController::class, 'read'])->name('lecteurs.read');


// ============================================================
// 2. ROUTES PROTEGEES (Darori Email w Password dial l-Admin)
// ============================================================

Route::middleware('auth')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Admin
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Section Admin (prefix 'admin')
    Route::prefix('admin')->group(function () {
        Route::resource('livres', LivreController::class);
        
        // Pages Management
        Route::get('livres/{livre}/pages', [PageController::class, 'index'])->name('pages.index');
        Route::get('livres/{livre}/pages/create', [PageController::class, 'create'])->name('pages.create');
        Route::post('livres/{livre}/pages', [PageController::class, 'store'])->name('pages.store');
        
        Route::get('pages/{page}', [PageController::class, 'show'])->name('pages.show');
        Route::get('pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
        Route::put('pages/{page}', [PageController::class, 'update'])->name('pages.update');
        Route::delete('pages/{page}', [PageController::class, 'destroy'])->name('pages.destroy');

        // Admin list readers
        Route::get('/lecteurs-list', [LecteurController::class, 'index'])->name('lecteurs.index');
    });
});

require __DIR__.'/auth.php';