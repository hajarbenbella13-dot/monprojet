<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LecteurController;
use App\Http\Controllers\Admin\LivreController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Auth\AuthenticatedSessionController; // Zid hada

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --- AUTHENTIFICATION ---

// 1. Login dyal l-Admin (Breeze Controller li fih LoginRequest)
// Flutter gha-isift l-email f blast 'login'
Route::post('/admin/login', [AuthenticatedSessionController::class, 'store']); 

// 2. Login dyal les Lecteurs (li khddam b PIN)
Route::post('/lecteur/login', [LecteurController::class, 'checkPinForFlutter']);
Route::post('/lecteur/register', [LecteurController::class, 'storeForFlutter']);


// --- L-KOTOB (BOOKS) ---
Route::get('/lecteur/{age}/livres', [LivreController::class, 'getLivresForFlutter']);


// --- L-PAGES ---
Route::get('/livres/{livre}/pages', [PageController::class, 'getPagesForFlutter']);


// --- DATA EXTRA ---
Route::get('/lecteur/{id}/data', [LecteurController::class, 'showForFlutter']);

// --- LOGOUT ---
Route::middleware('auth:sanctum')->post('/logout', [AuthenticatedSessionController::class, 'destroy']);