<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Lecteur;
use App\Models\Livre;
use App\Models\Page;
use App\Models\Progression;
use Illuminate\Http\Request;

class LecteurController extends Controller
{
    public function create()
    {
        return view('admin.lecteurs.create'); // form nom + age
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:150',
            'age' => 'required|integer|min:1',
        ]);

        $lecteur = Lecteur::create($request->only('nom', 'age'));

        // Create progressions pour tous les livres
        $livres = Livre::all();
        foreach ($livres as $livre) {
            $firstPage = Page::where('livre_id', $livre->id)->orderBy('num_page')->first();
            if ($firstPage) {
                Progression::create([
                    'lecteur_id' => $lecteur->id,
                    'livre_id' => $livre->id,
                    'derniere_page' => $firstPage->id
                ]);
            }
        }

        return redirect()->route('admin.lecteurs.show', $lecteur->id);
    }

    public function show(Lecteur $lecteur)
{
    // Toutes les progressions de ce lecteur
    $progressionsRaw = $lecteur->progressions()->with('livre')->get();

    // Transformer en array associatif par livre_id
    $progressions = $progressionsRaw->keyBy('livre_id');

    // Tous les livres adaptés à l'age du lecteur
    $livres = Livre::where('age_min', '<=', $lecteur->age)
                   ->where('age_max', '>=', $lecteur->age)
                   ->get();

    return view('admin.lecteurs.show', compact('lecteur', 'livres', 'progressions'));
}

public function continuer($lecteurId, $livreId)
{
    // جلب القارئ والكتاب
    $lecteur = \App\Models\Lecteur::findOrFail($lecteurId);
    
    // جلب التقدم
    $progression = \App\Models\Progression::where('lecteur_id', $lecteurId)
                                          ->where('livre_id', $livreId)
                                          ->first();

    // إذا كاين تقدم صيفطو للصفحة ديالو، وإلا صيفطو لصفحة 1
    $page = $progression ? $progression->derniere_page : 1;

    return redirect()->route('lecteurs.read', [$lecteurId, $livreId, $page]);
}


public function read(Lecteur $lecteur, Livre $livre, $page = null)
{
    // جميع صفحات الكتاب
    $pages = Page::where('livre_id', $livre->id)
                 ->orderBy('num_page')
                 ->get();

    if ($pages->isEmpty()) {
        return back();
    }

    // إذا ما تصيفطاتش page → نشوف واش عندو progression
    if (!$page) {
        $progression = Progression::where('lecteur_id', $lecteur->id)
                                  ->where('livre_id', $livre->id)
                                  ->first();

        $page = $progression ? $progression->derniere_page : 1;
    }

    $currentPage = $pages->firstWhere('num_page', $page);

    if (!$currentPage) {
        $currentPage = $pages->first();
        $page = $currentPage->num_page;
    }

    // تحديث progression
    Progression::updateOrCreate(
        [
            'lecteur_id' => $lecteur->id,
            'livre_id' => $livre->id,
        ],
        [
            'derniere_page' => $page
        ]
    );

    return view('admin.lecteurs.read', compact(
        'lecteur',
        'livre',
        'currentPage',
        'page',
        'pages'
    ));
}
}