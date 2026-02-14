<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use App\Models\Page;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'livresCount' => Livre::count(),
            'pagesCount' => Page::count(),
            'audioPagesCount' => Page::whereNotNull('audio')->count(),
            'latestLivres' => Livre::latest()->take(5)->get(),
        ]);
       
    }
}
