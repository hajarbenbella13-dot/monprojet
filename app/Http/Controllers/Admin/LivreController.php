<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Livre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LivreController extends Controller
{
    // ... (Code dyal Web Admin bqa kif ma hwa) ...

    // ================= Flutter API =================
    
    // 1. Jib l-kotob 3la hsab l-age
    public function getLivresForFlutter($age)
    {
        $livres = Livre::where('age_min', '<=', $age)
                        ->where('age_max', '>=', $age) // Zdt hadi bach t-koun precis
                        ->get()
                        ->map(function ($livre) {
                            // Full URL l-Photo w l-Audio
                            $livre->photo = $livre->photo ? url('storage/' . $livre->photo) : null;
                            $livre->audio = $livre->audio ? url('storage/' . $livre->audio) : null;
                            return $livre;
                        });

        return response()->json([
            'status' => 'success',
            'livres' => $livres
        ]);
    }

    // 2. 🔥 HADI HIYA LI KHASSAK: Jib l-pages dyal ktab m3ayan
    public function getPagesForFlutter($id)
    {
        // Kan-jibou l-livre m3a l-pages dyalo
        $livre = Livre::with('pages')->find($id);

        if (!$livre) {
            return response()->json(['status' => 'error', 'message' => 'Livre non trouvé'], 404);
        }

        // Sggad l-URLs dyal l-pages
        $pages = $livre->pages->map(function ($page) {
            $page->image = $page->image ? url('storage/' . $page->image) : null;
            $page->audio = $page->audio ? url('storage/' . $page->audio) : null;
            return $page;
        });

        return response()->json([
            'status' => 'success',
            'pages' => $pages
        ]);
    }

    // 3. Ajouter via Flutter (ila bghiti t-upload ktab mn l-app)
    public function storeForFlutter(Request $request)
    {
        // ... (Nfs l-code dyalk s-hih) ...
    }
}