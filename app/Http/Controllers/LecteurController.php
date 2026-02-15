<?php

namespace App\Http\Controllers;

use App\Models\Lecteur;
use App\Models\Livre;
use App\Models\Page;
use App\Models\Progression;
use Illuminate\Http\Request;

class LecteurController extends Controller
{
    public function create()
    {
        return view('admin.lecteurs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:150',
            'age' => 'required|integer|min:1',
        ]);

        $lecteur = Lecteur::create($request->only('nom', 'age'));

        // ديما نبداو بـ الصفحة رقم 1 
        $livres = Livre::all();
        foreach ($livres as $livre) {
            Progression::create([
                'lecteur_id' => $lecteur->id,
                'livre_id' => $livre->id,
                'derniere_page' => 1 // هنا كنحطو رقم الصفحة ماشي الـ ID
            ]);
        }

        return redirect()->route('lecteurs.show', $lecteur->id);
    }

    public function show(Lecteur $lecteur)
    {
        $progressionsRaw = $lecteur->progressions()->with('livre')->get();
        $progressions = $progressionsRaw->keyBy('livre_id');

        $livres = Livre::where('age_min', '<=', $lecteur->age)
                       ->where('age_max', '>=', $lecteur->age)
                       ->get();

        return view('admin.lecteurs.show', compact('lecteur', 'livres', 'progressions'));
    }

    public function continuer($lecteurId, $livreId)
{
    // جلب التقدم
    $progression = \App\Models\Progression::where('lecteur_id', $lecteurId)
                                          ->where('livre_id', $livreId)
                                          ->first();

    // نحدد رقم الصفحة
    $page = $progression ? $progression->derniere_page : 1;

    // أهم حاجة: التوجيه بالـ IDs
    return redirect()->route('lecteurs.read', [
        'lecteur' => $lecteurId, 
        'livre' => $livreId, 
        'page' => $page
    ]);
}
public function read(Lecteur $lecteur, Livre $livre, $page = null)
{
    $pages = Page::where('livre_id', $livre->id)
                 ->orderBy('num_page')
                 ->get();

    // 💡 هنا كاين المشكل: يلا الكتاب خاوي كيرجعك للور
    if ($pages->isEmpty()) {
        return back()->with('error', '⚠️ Ce livre ne contient aucune page pour le moment.');
    }

    // ... باقي الكود كيبقى كيفما هو
}
}