<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Progression;

class ProgressionController extends Controller
{
    // Save or update the last read page for a user/book
   public function saveProgress(Request $request)
{
    $request->validate([
        'lecteur_id' => 'required|integer|exists:lecteurs,id',
        'livre_id' => 'required|integer|exists:livres,id',
        'derniere_page' => 'required|integer|min:0',
    ]);

    $progress = Progression::updateOrCreate(
        [
            'lecteur_id' => $request->lecteur_id,
            'livre_id' => $request->livre_id,
        ],
        [
            'derniere_page' => $request->derniere_page,
        ]
    );

    // Get total pages for this book
    $livre = \App\Models\Livre::find($request->livre_id);
    $totalPages = $livre && isset($livre->pages) ? count($livre->pages) : 1;

    $isFinished = $progress->derniere_page >= $totalPages - 1;

    return response()->json([
        'derniere_page' => $progress->derniere_page,
        'is_finished' => $isFinished,
    ]);
}
   public function getProgress($lecteur_id, $livre_id)
{
    $progress = Progression::where('lecteur_id', $lecteur_id)
        ->where('livre_id', $livre_id)
        ->first();

    $lastPage = $progress ? $progress->derniere_page : 0;

    // Get total pages for this book
    $livre = \App\Models\Livre::find($livre_id);
    $totalPages = $livre && isset($livre->pages) ? count($livre->pages) : 1;

    $isFinished = $lastPage >= $totalPages - 1;

    return response()->json([
        'derniere_page' => $lastPage,
        'is_finished' => $isFinished,
    ]);
}
}