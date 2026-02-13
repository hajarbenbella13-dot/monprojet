<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Livre;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function create(Livre $livre)
    {
        
        return view('admin.pages.create', compact('livre'));
    }

    public function store(Request $request, Livre $livre)
{
   
    $request->validate([
        'num_page' => 'required|integer',
        'image'       => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'audio' => 'nullable|mimetypes:audio/mpeg,audio/mp3,audio/wav,audio/x-wav|max:10000',
        'contenu'     => 'required|string',
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
}