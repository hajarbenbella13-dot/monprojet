<?php

namespace App\Http\Controllers;

use App\Models\Lecteur;
use App\Models\Livre;
use Illuminate\Http\Request;

class LecteurController extends Controller
{
    // Register (Flutter)
    public function storeForFlutter(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'pin' => 'required|digits:4',
            'age_range' => 'required'
        ]);

        $dejaPris = Lecteur::where('nom', $request->nom)
                           ->where('pin', $request->pin)
                           ->exists();

        if ($dejaPris) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ce prénom est déjà utilisé avec ce code PIN.'
            ], 400);
        }

        $ageValue = ($request->age_range == '2-5') ? 5 : 10;

        $lecteur = Lecteur::create([
            'nom' => $request->nom,
            'pin' => $request->pin,
            'age' => $ageValue 
        ]);

        return response()->json([
            'status' => 'success',
            'lecteur_id' => $lecteur->id,
            'nom' => $lecteur->nom,
            'age' => $lecteur->age
        ]);
    }

    // Login (Flutter)
    public function checkPinForFlutter(Request $request)
    {
        $lecteur = Lecteur::where('nom', $request->nom)
                         ->where('pin', $request->pin)
                         ->first();

        if ($lecteur) {
            return response()->json([
                'status' => 'success',
                'lecteur_id' => $lecteur->id,
                'nom' => $lecteur->nom,
                'age' => $lecteur->age // Ghadi idouz l-BooksScreen
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Nom ou PIN incorrect'
        ], 401);
    }

    // Get Livres by Age (Flutter)
    public function showForFlutter($age)
{
    $livres = Livre::where('age_min', '<=', $age)
                   ->where('age_max', '>=', $age)
                   ->get()
                   ->map(function($livre) {
                       if ($livre->photo) {
                           // 💡 Ila kanti kheddam f localhost, t-aked mn APP_URL f .env
                           $livre->photo = asset('storage/' . $livre->photo);
                       }
                       return $livre;
                   });

    // ✅ Rejje3 ghir $livres bo7dha (List), machi Map fiha 'status'
    return response()->json($livres);
}
}