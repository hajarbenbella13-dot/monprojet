<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Livre;

class LivreController extends Controller
{
    // List tous les livres
    public function index()
    {
        $livres = Livre::all();
        return view('admin.livres.index', compact('livres'));
    }

    // Form ajouter nouveau livre
    public function create()
    {
        return view('admin.livres.create');
    }

    // Stocker nouveau livre
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg,gif',
            'ageMin' => 'nullable|integer',
            'ageMax' => 'nullable|integer',
        ]);

        $livre = new Livre();
        $livre->titre = $request->titre;
        $livre->description = $request->description;
        $livre->ageMin = $request->ageMin;
        $livre->ageMax = $request->ageMax;

        // Upload photo si exist
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $livre->photo = $filename;
        }

        $livre->save();

        return redirect()->route('livres.index')->with('success', 'Livre ajouté avec succès!');
    }

    // Form éditer livre
    public function edit(Livre $livre)
    {
        return view('admin.livres.edit', compact('livre'));
    }

    // Update livre
    public function update(Request $request, Livre $livre)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg,gif',
            'ageMin' => 'nullable|integer',
            'ageMax' => 'nullable|integer',
        ]);

        $livre->titre = $request->titre;
        $livre->description = $request->description;
        $livre->ageMin = $request->ageMin;
        $livre->ageMax = $request->ageMax;

        if($request->hasFile('photo')){
            $file = $request->file('photo');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $livre->photo = $filename;
        }

        $livre->save();

        return redirect()->route('livres.index')->with('success', 'Livre modifié avec succès!');
    }

    // Supprimer livre
    public function destroy(Livre $livre)
    {
        $livre->delete();
        return redirect()->route('livres.index')->with('success', 'Livre supprimé avec succès!');
    }
}
