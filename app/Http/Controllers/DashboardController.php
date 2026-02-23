<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Page;
use App\Models\Lecteur;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. جمع الإحصائيات
        $stats = [
            'total_lecteurs' => Lecteur::count(),
            'total_livres'   => Livre::count(),
            'total_pages'    => Page::count(),
            // آخر 5 قراء
            'recent_lecteurs' => Lecteur::latest()->take(5)->get(),
            // كتب خاوية
            'livres_vides' => Livre::doesntHave('pages')->count(),
        ];

        // 2. Livres populaires حسب progressions
        $popular_livres = Livre::withCount('progressions')
                            ->orderBy('progressions_count', 'desc')
                            ->take(3)
                            ->get();

        // 3. إرسال البيانات للـ View
        return view('dashboard', compact('stats', 'popular_livres'));
    }
}