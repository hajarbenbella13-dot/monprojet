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

        return redirect()->route('lecteurs.show', $lecteur->id);
    }

    public function show(Lecteur $lecteur)
    {
        // Afficher tous les livres avec la dernière page lu
        $progressions = $lecteur->progressions()->with('livre', 'page')->get();

        return view('lecteurs.show', compact('lecteur', 'progressions'));
    }

    public function pageSuivante(Lecteur $lecteur, Livre $livre)
    {
        $progression = Progression::where('lecteur_id', $lecteur->id)
                        ->where('livre_id', $livre->id)->first();

        $currentPage = Page::find($progression->derniere_page);

        $nextPage = Page::where('livre_id', $livre->id)
                        ->where('num_page', '>', $currentPage->num_page)
                        ->orderBy('num_page')->first();

        if ($nextPage) {
            $progression->update(['derniere_page' => $nextPage->id]);
        }

        return redirect()->route('lecteurs.show', $lecteur->id);
    }
}
