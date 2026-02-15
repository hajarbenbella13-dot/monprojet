<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Page;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. جمع الإحصائيات في array سميتو $stats
        $stats = [
            'total_lecteurs' => \App\Models\Lecteur::count(),
            'total_livres'   => \App\Models\Livre::count(),
            'total_pages'    => \App\Models\Page::count(),
            // كنجيبو آخر 5 قراء
            'recent_lecteurs' => \App\Models\Lecteur::latest()->get(),
            // كنشوفو واش كاين شي كتب خاوية
            'livres_vides' => \App\Models\Livre::doesntHave('pages')->count(),
        ];
    
        $popular_livres = \App\Models\Livre::withCount('progressions')
                            ->orderBy('progressions_count', 'desc')
                            ->take(3)
                            ->get();
    
        // 3. صيفط كاع المتغيرات للـ View
        return view('dashboard', compact('stats', 'popular_livres'));
    }
}
