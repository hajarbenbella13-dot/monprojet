<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Livre; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class LivreController extends Controller
{
    public function storeForFlutter(Request $request)
    {
        // ... koud dyal storeForFlutter ...
        $validator = Validator::make($request->all(), [
            'titre'   => 'required',
            'age_min' => 'required',
            'age_max' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $livre = Livre::create([
            'titre'       => $request->titre,
            'description' => $request->description,
            'age_min'     => $request->age_min,
            'age_max'     => $request->age_max,
            'photo'       => $request->hasFile('photo') ? $request->file('photo')->store('livres', 'public') : null,
            
        ]);

        return response()->json(['status' => 'success', 'livre' => $livre], 201);
    }
   public function index()
{
    // Eager loading dyal l-pages
    $livres = \App\Models\Livre::with('pages')->get(); 
    
    return response()->json([
        'status' => 'success',
        'livres' => $livres
    ], 200);
}
public function update(Request $request, $id)
{
    $livre = \App\Models\Livre::findOrFail($id);

    // Validation
    $request->validate([
        'titre' => 'required|string|max:255',
        'age_min' => 'required|integer',
        'age_max' => 'required|integer',
    ]);

    $livre->titre = $request->titre;
    $livre->description = $request->description;
    $livre->age_min = $request->age_min;
    $livre->age_max = $request->age_max;

    // Ila kanti sifti photo jdida
    if ($request->hasFile('photo')) {
        // Suprimer l-photo l-9dima ila bghiti t-nqi l-espace
        if ($livre->photo) {
            \Storage::disk('public')->delete($livre->photo);
        }
        $path = $request->file('photo')->store('livres', 'public');
        $livre->photo = $path;
    }

    $livre->save();

    return response()->json([
        'status' => 'success',
        'message' => 'Livre modifié avec succès',
        'livre' => $livre
    ], 200);
}
public function destroy($id)
{
    try {
        $livre = Livre::findOrFail($id);

        // 1. Msa7 l-photo dyal l-kitab mn l-disk
        if ($livre->photo) {
            \Storage::disk('public')->delete($livre->photo);
        }

        // 2. Msa7 l-fichiers dyal l-pages (Images/Audios)
        foreach ($livre->pages as $page) {
            if ($page->image) \Storage::disk('public')->delete($page->image);
            if ($page->audio) \Storage::disk('public')->delete($page->audio);
        }

        // 3. Msa7 mn l-base de données
        $livre->delete(); 

        return response()->json(['message' => 'Livre supprimé avec succès']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
}