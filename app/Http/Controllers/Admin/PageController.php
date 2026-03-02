<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Livre;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    // --- HAD L-FONCTION HIA LI GHAT-ST9BEL L-DATA MN FLUTTER ---
    public function storeForFlutter(Request $request, $livreId)
    {
        try {
            // 1. Validation
            $request->validate([
                'num_page' => 'required|integer',
                'contenu'  => 'required|string',
                'image'    => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'audio'    => 'nullable|mimes:mp3,wav,aac|max:20000',
            ]);

            $livre = Livre::findOrFail($livreId);

            // 2. Upload Image
            $imagePath = $request->file('image')->store('pages/images', 'public');

            // 3. Upload Audio (ila kan)
            $audioPath = null;
            if ($request->hasFile('audio')) {
                $audioPath = $request->file('audio')->store('pages/audios', 'public');
            }

            // 4. Creation f l-Base de données
            $page = Page::create([
                'livre_id' => $livre->id,
                'num_page' => $request->num_page,
                'contenu'  => $request->contenu,
                'image'    => $imagePath,
                'audio'    => $audioPath,
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Page ajoutée avec succès!',
                'page'    => $page
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }

    // L-fonction li derti dyal l-GET (mzyana)
    public function getPagesForFlutter(Livre $livre)
    {
        $pages = $livre->pages()->orderBy('num_page', 'asc')->get()->map(function ($page) {
            return [
                'id'       => $page->id,
                'num_page' => $page->num_page,
                'contenu'  => $page->contenu,
                // asset() darouria bach t-ban tswira f Flutter
                'image'    => $page->image ? asset('storage/' . $page->image) : null,
                'audio'    => $page->audio ? asset('storage/' . $page->audio) : null,
            ];
        });

        return response()->json(['status' => 'success', 'pages' => $pages], 200);
    }
    public function updateForFlutter(Request $request, $id)
    {
        try {
            $page = Page::findOrFail($id);

            $request->validate([
                'num_page' => 'required|integer',
                'contenu'  => 'required|string',
                'image'    => 'nullable|image|max:2048',
                'audio'    => 'nullable|file|max:20000',
            ]);

            // Update Image (Ila t-siftat wa7da jdida)
            if ($request->hasFile('image')) {
                if ($page->image) Storage::disk('public')->delete($page->image);
                $page->image = $request->file('image')->store('pages/images', 'public');
            }

            // Update Audio (Ila t-sift wa7d jdid)
            if ($request->hasFile('audio')) {
                if ($page->audio) Storage::disk('public')->delete($page->audio);
                $page->audio = $request->file('audio')->store('pages/audios', 'public');
            }

            $page->update([
                'num_page' => $request->num_page,
                'contenu'  => $request->contenu,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Page modifiée!'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    // --- 4. SUPPRIMER UNE PAGE (DELETE) ---
    public function destroyForFlutter($id)
    {
        try {
            $page = Page::findOrFail($id);

            // N-mse7 l-fichiers mn l-biro (Storage)
            if ($page->image) Storage::disk('public')->delete($page->image);
            if ($page->audio) Storage::disk('public')->delete($page->audio);

            $page->delete();

            return response()->json(['status' => 'success', 'message' => 'Page supprimée!'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}