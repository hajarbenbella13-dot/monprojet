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
    // 1. Validation d l-anwa3
    $request->validate([
        'nom' => 'required|string|max:100',
        'pin' => 'required|digits:4',
        'age_range' => 'required'
    ]);

    // 2. 🔥 L-MAGIE: Check wach had s-miya m3a had l-PIN déjà khdam bihom chi wa7ed
    $dejaPris = Lecteur::where('nom', $request->nom)
                       ->where('pin', $request->pin)
                       ->exists();

    if ($dejaPris) {
        return back()->with('error', "Ce prénom est déjà utilisé avec ce code PIN. S'il te plaît, choisis un autre code PIN pour te différencier ! ✨");
    }

    // 3. Ila kan PIN jdid, kammal l-khidma dyalk
    $ageValue = ($request->age_range == '2-5') ? 5 : 10;

    $lecteur = Lecteur::create([
        'nom' => $request->nom,
        'pin' => $request->pin,
        'age' => $ageValue 
    ]);

    // ... setup progressions ...
    
    return redirect()->route('lecteurs.show', $lecteur->id);
}
public function selectLecteur($id)
{
    $lecteur = Lecteur::findOrFail($id);
    
    session(['active_lecteur_id' => $lecteur->id]);
    session(['active_lecteur_nom' => $lecteur->nom]);

    return redirect()->route('lecteurs.show', $id);
}

public function index()
{
    $lecteurs = Lecteur::all();
    return view('lecteurs.index', compact('lecteurs')); 
}

public function checkPin(Request $request)
{
    // Kan-qalbo 3la l-lecteur li 3ndu had s-miya W had l-PIN b-joj
    $lecteur = Lecteur::where('nom', $request->nom)
                     ->where('pin', $request->pin)
                     ->first();

    if ($lecteur) {
        // ✅ Lqinah! Dabba Laravel 3arf i-ddih l l-ID dyal Yanis l-mounassib
        session(['active_lecteur_id' => $lecteur->id]);
        return redirect()->route('lecteurs.show', $lecteur->id);
    }

    // ❌ Ila mal9ahch, ma-ghadi n-goulo lih la s-miya ghalta la PIN ghalat (Security)
    return back()->with('error', 'Oups! Le prénom ou le code PIN est incorrect. ❌');
}
    public function show(Lecteur $lecteur)
{
    $progressionsRaw = $lecteur->progressions()->with('livre')->get();
    $progressions = $progressionsRaw->keyBy('livre_id');

    $livres = Livre::where('age_min', '<=', $lecteur->age)
                   ->where('age_max', '>=', $lecteur->age)
                   ->get();

                   return view('admin.lecteurs.show', [
                    'lecteur' => $lecteur, 
                    'livres' => $livres,
                    'progressions' => $progressions
                ]);}
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