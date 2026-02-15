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
public function read(Lecteur $lecteur, Livre $livre, $page = 1)
{
    // 1. Qlleb 3la l-page b raqmha
    $currentPage = Page::where('livre_id', $livre->id)
                       ->where('num_page', $page)
                       ->first();

    // 2. Ila l-page makaynach
    if (!$currentPage) {
        if ($page == 1) {
            return redirect()->route('lecteurs.show', $lecteur->id)
                             ->with('error', 'Had l-livre khawi.');
        }
        return redirect()->route('lecteurs.read', [$lecteur->id, $livre->id, 1]);
    }

    // 3. Update l-progression
    Progression::updateOrCreate(
        ['lecteur_id' => $lecteur->id, 'livre_id' => $livre->id],
        ['derniere_page' => $page]
    );

    // 4. Les pages Suivante/Précédente
    $nextPage = Page::where('livre_id', $livre->id)->where('num_page', $page + 1)->first();
    $prevPage = Page::where('livre_id', $livre->id)->where('num_page', $page - 1)->first();

    // ⚠️ Hna khass l-path ikoun s7i7 3la hsab fin 7atiti l-fichier
    return view('admin.lecteurs.read', [
        'lecteur'     => $lecteur,
        'livre'       => $livre,
        'currentPage' => $currentPage, // Hadi hiya lli kant naqsa
        'nextPage'    => $nextPage,
        'prevPage'    => $prevPage
    ]);
}}