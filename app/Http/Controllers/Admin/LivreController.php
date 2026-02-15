<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Livre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LivreController extends Controller
{
    public function index()
    {
        $livres = Livre::latest()->get(); 
        return view('admin.livres.index', compact('livres'));
    }

    public function create()
    {
        return view('admin.livres.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'age_range'   => 'required|in:2-5,6-10', // Choix forcé
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'audio'       => 'nullable|mimes:mp3,wav|max:5000',
        ]);

        $data = $request->all();

        // On découpe l'âge choisi (ex: "2-5")
        $ages = explode('-', $request->age_range);
        $data['age_min'] = $ages[0];
        $data['age_max'] = $ages[1];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('livres', 'public');
        }

        if ($request->hasFile('audio')) {
            $data['audio'] = $request->file('audio')->store('audios', 'public');
        }

        Livre::create($data);
        return redirect()->route('livres.index')->with('success', 'Livre ajouté avec succès!');
    }


    public function edit(Livre $livre) 
    {
        return view('admin.livres.edit', compact('livre'));
    }
    
    public function update(Request $request, Livre $livre) 
    {
        $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'age_range'   => 'required|in:2-5,6-10',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'audio'       => 'nullable|mimes:mp3,wav|max:5000',
        ]);

        $data = $request->all();

        // On découpe l'âge
        $ages = explode('-', $request->age_range);
        $data['age_min'] = $ages[0];
        $data['age_max'] = $ages[1];

        if ($request->hasFile('photo')) {
            if ($livre->photo) { Storage::disk('public')->delete($livre->photo); }
            $data['photo'] = $request->file('photo')->store('livres', 'public');
        }

        if ($request->hasFile('audio')) {
            if ($livre->audio) { Storage::disk('public')->delete($livre->audio); }
            $data['audio'] = $request->file('audio')->store('audios', 'public');
        }
    
        $livre->update($data);
        return redirect()->route('livres.index')->with('success', 'Livre modifié avec succès !');
    }
    
    public function destroy(Livre $livre) 
    {
        if ($livre->photo) { Storage::disk('public')->delete($livre->photo); }
        if ($livre->audio) { Storage::disk('public')->delete($livre->audio); }
        $livre->delete();
        return redirect()->route('livres.index')->with('success', 'Livre supprimé !');
    }
}