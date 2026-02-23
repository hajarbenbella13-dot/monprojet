<?php
use Illuminate\Support\Facades\Route;

// Page l-oula dial Laravel (Admin Dashboard masalan)
Route::get('/', function () {
    return view('welcome');
});

// Hadu dyal Auth dial Laravel (Breeze/Jetstream)
require __DIR__.'/auth.php';

// Hadu l-Admin panel dyalk (Routes dyal LivreController/PageController dial Web)
Route::middleware(['auth'])->group(function () {
    // ... Routes dial l-web (Admin) hna
});