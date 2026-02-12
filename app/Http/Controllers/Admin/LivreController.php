<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Livre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LivreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // 1. Njibou ga3 l'ktouba mn la base de données
    $livres = \App\Models\Livre::all(); 
    return redirect()->route('livres.index');

    $livres = Livre::latest()->get();
    // 2. N-rej3o la vue li kayna f resources/views/admin/livres/index.blade.php
    return view('admin.livres.index', compact('livres'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.livres.create');
    }
    

    // 2. Traiter l'ajout (Enregistrer)
    public function store(Request $request)
    {
        // a. Validation: t-akkdi bli kolchi mktoub s7i7
        $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'age_min'     => 'nullable|integer',
            'age_max'     => 'nullable|integer',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
            'audio'       => 'nullable|mimes:mp3,wav|max:5000', // Max 5MB
        ]);

        $data = $request->all();

        // b. Khbi l'Photo f dossier storage/app/public/livres
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('livres', 'public');
        }

        // c. Khbi l'Audio f dossier storage/app/public/audios
        if ($request->hasFile('audio')) {
            $data['audio'] = $request->file('audio')->store('audios', 'public');
        }

        // d. Créer le livre f SQL
        Livre::create($data);

       
        // e. Reje3 l'index b message d'succès
        return redirect()->route('livres.index')->with('success', 'Livre ajouté avec succès!');
    }

    // ... baqi les autres méthodes (index, edit, etc.)

}
