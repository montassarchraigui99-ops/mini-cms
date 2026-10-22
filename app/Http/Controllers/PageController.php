<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('welcome');
    }

    public function about(): View
    {
        return view('a-propos', [
            'auteur' => 'Montassar Chraigui',
            'groupe' => 'MDW',
        ]);
    }

    public function time(): string
    {
        return 'Il est ' . now()->format('H:i:s');
    }
}
