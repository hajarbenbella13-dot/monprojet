<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LecteurController;
use App\Http\Controllers\Admin\LivreController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProgressionController;

/*
|--------------------------------------------------------------------------
| API Routes - Projet HKIDS
|--------------------------------------------------------------------------
*/

// --- ROUTES PUBLIQUES (Accessibles sans Token) ---

// Authentification Admin (Retourne un Token Sanctum)
Route::post('/admin/login', [AuthenticatedSessionController::class, 'store']); 

// Authentification et Inscription des Lecteurs (Enfants)
Route::post('/lecteur/login', [LecteurController::class, 'checkPinForFlutter']);
Route::post('/lecteur/register', [LecteurController::class, 'storeForFlutter']);

// Consultation des livres et des pages
Route::get('/lecteur/{age}/livres', [LivreController::class, 'getLivresForFlutter']);

// T-aked mn had l-path:
Route::get('/livres/{livre}/pages', [PageController::class, 'getPagesForFlutter']);

// --- ROUTES PROTÉGÉES (Nécessitent un Token dans le Header) ---

Route::middleware('auth:sanctum')->group(function () {
    
    // Route pour vérifier si l'utilisateur est toujours connecté
    Route::get('/user', function () {
        return auth()->user();
    });

    // Déconnexion (Supprime le Token)
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
    
});
// f api.php
Route::get('/lecteur/{age}/livres', [LecteurController::class, 'showForFlutter']);
Route::get('/lecteur/{id}/livres', [LecteurController::class, 'getLivres']);
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::post('/admin/livres', [LivreController::class, 'storeForFlutter']);
// Route bach l-Admin i-jib ga3 l-ktoub f Flutter
Route::get('/admin/livres', [LivreController::class, 'index']);
Route::put('/admin/livres/{id}', [LivreController::class, 'update']);
// Supprimer un livre ✅
Route::delete('/admin/livres/{id}', [LivreController::class, 'destroy']);
// POST: khass i-koun {livreId} bach i-matchi l-variable $livreId f storeForFlutter
Route::post('/admin/livres/{livreId}/pages', [PageController::class, 'storeForFlutter']);

// GET: khass i-koun {livre} bach i-matchi l-type hint (Livre $livre) f getPagesForFlutter
Route::get('/admin/livres/{livre}/pages', [PageController::class, 'getPagesForFlutter']);
// Routes f api.php
// 3. Modifier Page: URL ghadi i-koun /api/admin/pages/ID
Route::post('/admin/pages/{id}', [PageController::class, 'updateForFlutter']);

// 4. Supprimer Page: URL ghadi i-koun /api/admin/pages/ID
Route::delete('/admin/pages/{id}', [PageController::class, 'destroyForFlutter']);
Route::post('/progression', [ProgressionController::class, 'saveProgress']);
Route::get('/progression/{lecteur_id}/{livre_id}', [ProgressionController::class, 'getProgress']);
