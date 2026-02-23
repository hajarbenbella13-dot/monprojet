<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Livre;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    // API dyal Flutter bach t-jib ga3 l-pages dyal ktab
    public function getPagesForFlutter(Livre $livre)
    {
        try {
            $pages = $livre->pages()->orderBy('num_page', 'asc')->get()->map(function ($page) {
                return [
                    'id'       => $page->id,
                    'num_page' => $page->num_page,
                    'contenu'  => $page->contenu,
                    // asset() kat-zid http://localhost:8000/ storage automatic
                    'image'    => $page->image ? asset('storage/' . $page->image) : null,
                    'audio'    => $page->audio ? asset('storage/' . $page->audio) : null,
                ];
            });

            return response()->json([
                'status' => 'success',
                'pages'  => $pages
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }
}