<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Page;
use App\Models\Lecteur;

class DashboardController extends Controller
{
    public function index()
{
    $stats = [
        'total_lecteurs' => Lecteur::count(),
        'total_livres'   => Livre::count(),
        'total_pages'    => Page::count(),
        'recent_lecteurs' => Lecteur::latest()->take(5)->get(),
        'livres_vides' => Livre::doesntHave('pages')->count(),
    ];

    $popular_livres = Livre::withCount('progressions')
                            ->orderBy('progressions_count', 'desc')
                            ->take(3)
                            ->get();

    // --- LA SEULE MODIFICATION NÉCESSAIRE ---
    // Si la requête vient de Flutter (API), on envoie du JSON
    if (request()->wantsJson() || request()->is('api/*')) {
        return response()->json([
            'stats' => $stats,
            'popular_livres' => $popular_livres
        ]);
    }

    // Sinon, on garde ton affichage habituel pour le site web
    return view('dashboard', compact('stats', 'popular_livres'));
}
}