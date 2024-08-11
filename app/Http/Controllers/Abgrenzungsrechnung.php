<?php

namespace App\Http\Controllers;

use App\Models\Abgrenzungsrechnung as ModelsAbgrenzungsrechnung;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class Abgrenzungsrechnung extends Controller
{
    /**
     * Show the general profile settings screen.
     */
    public function show(Request $request): Response
    {
        return Inertia::render('Abgrenzungsrechnung', [
            'items' => ModelsAbgrenzungsrechnung::all(),
        ]);
    }
}
