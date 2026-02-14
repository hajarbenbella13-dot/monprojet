<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Livre;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // 👈 Darori t-zid had l-line bach kheddam Rule

class PageController extends Controller
{
    
    public function create(Livre $livre, Request $request)
{
    $editingPage = $request->has('edit') ? Page::findOrFail($request->edit) : null;
    return view('admin.pages.create', compact('livre', 'editingPage'));
}


    public function store(Request $request, Livre $livre)
    {
        $request->validate([
            'num_page' => [
                'required',
                'integer',
                // 🛡️ Hna fin kayna l-7imaya:
                Rule::unique('pages')->where(function ($query) use ($livre) {
                    return $query->where('livre_id', $livre->id);
                }),
            ],
            'image'   => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'audio'   => 'nullable|mimetypes:audio/mpeg,audio/mp3,audio/wav,audio/x-wav|max:10000',
            'contenu' => 'required|string',
        ], [
            // Message d l'erreur personnalisé
            'num_page.unique' => 'Had l-paj (' . $request->num_page . ') Ce numéro de page existe déjà pour ce livre.!',
        ]);

        $imagePath = $request->file('image')->store('pages/images', 'public');
        
        $audioPath = null;
        if ($request->hasFile('audio')) {
            $audioPath = $request->file('audio')->store('pages/audios', 'public');
        }

        $page = new \App\Models\Page();
        $page->livre_id = $livre->id;
        $page->num_page = $request->num_page;
        $page->image = $imagePath;
        $page->audio = $audioPath;
        $page->contenu = $request->contenu;
        
        if($page->save()) {
            return redirect()->back()->with('success', 'Page ajoutée avec succès!');
        } else {
            return "Erreur lors de l'enregistrement";
        }
    }
    // 1. Suppression
public function destroy(Page $page)
{
    // Mseh l-fichiers mn storage bach mat-3mmrch l-disk khwa
    if ($page->image) \Storage::disk('public')->delete($page->image);
    if ($page->audio) \Storage::disk('public')->delete($page->audio);
    
    $page->delete();

    return redirect()->back()->with('success', 'Page supprimée avec succès !');
}


// Show single page
public function show(Page $page)
{
    return view('admin.pages.show', compact('page'));
}


// update
public function update(Request $request, Page $page)
{
    $request->validate([
        'image'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'audio'   => 'nullable|mimetypes:audio/mpeg,audio/mp3,audio/wav,audio/x-wav|max:10000',
        'contenu' => 'required|string',
    ]);

    // Update contenu
    $page->contenu = $request->contenu;

    // Update image si upload jdida
    if ($request->hasFile('image')) {
        if($page->image) \Storage::disk('public')->delete($page->image);
        $page->image = $request->file('image')->store('pages/images', 'public');
    }

    // Update audio si upload jdida
    if ($request->hasFile('audio')) {
        if($page->audio) \Storage::disk('public')->delete($page->audio);
        $page->audio = $request->file('audio')->store('pages/audios', 'public');
    }

    
    $page->save();
    return redirect()->route('pages.create', $page->livre_id)
    ->with('success', 'Page modifiée avec succès !');
}

}