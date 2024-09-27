<?php

use App\Http\Controllers\AbgrenzungsrechnungController;
use App\Http\Controllers\AbweichungsanalysenController;
use App\Http\Controllers\BreakEvensController;
use App\Http\Controllers\DeckungsbeitragController;
use App\Http\Controllers\PreisuntergrenzenController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Abgrenzungsrechnung
Route::resource('abgrenzungsrechnung', AbgrenzungsrechnungController::class)->only([
    'index', 'store', 'destroy'
])->middleware(['auth', 'verified'])->names([
    'index' => 'abgrenzungsrechnung.index',  // Set route names correctly
    'store' => 'abgrenzungsrechnung.store',
    'destroy' => 'abgrenzungsrechnung.destroy'
]);

// abweichungsanalyse
Route::resource('abweichungsanalyse', AbweichungsanalysenController::class)->only([
    'index', 'store', 'destroy'
])->middleware(['auth', 'verified'])->names([
    'index' => 'abweichungsanalyse.index',  // Ensure correct naming here
    'store' => 'abweichungsanalyse.store',
    'destroy' => 'abweichungsanalyse.destroy'
]);

//Make-or-Buy
Route::get('/make-or-buy', function () {
    return Inertia::render('MakeOrBuy');
})->middleware(['auth', 'verified'])->name('makeOrBuy');

//Innerbetriebliche Leistungsverrechnung
Route::get('/iblv', function () {
    return Inertia::render('InnerbetrieblicheLeistungsverrechnung');
})->middleware(['auth', 'verified'])->name('InnerbetrieblicheLeistungsverrechnung');

// Break-Even
Route::resource('break-even', BreakEvensController::class)->only([
    'index', 'store', 'destroy'
])->middleware(['auth', 'verified'])->names([
    'index' => 'breakEven.index',  // Ensure correct naming here
    'store' => 'breakEven.store',
    'destroy' => 'BreakEven.destroy'
]); 

// Deckungsbeitragrechnung
Route::resource('/deckungsbeitrag', DeckungsbeitragController::class)->only([
    'index', 'store', 'destroy'
])->middleware(['auth', 'verified'])->names([
    'index' => 'deckungsbeitragrechnung.index',  // Ensure correct naming here
    'store' => 'deckungsbeitragrechnung.store',
    'destroy' => 'deckungsbeitragrechnung.destroy'
]); 

Route::get('/getDeckungsbeitragsrechnungen', [DeckungsbeitragController::class, 'getDeckungsbeitragsrechnungen'])->name('getDeckungsbeitragsrechnungen');
Route::get('/getAbweichungsrechnung', [AbweichungsanalysenController::class, 'getAbweichungsrechnung'])->name('getAbweichungsrechnung');

// Preisuntergrenze
Route::resource('/preisuntergrenze', PreisuntergrenzenController::class)->only([
    'index', 'store', 'destroy'
])->middleware(['auth', 'verified'])->names([
    'index' => 'preisuntergrenze.index',  // Ensure correct naming here
    'store' => 'preisuntergrenze.store',
    'destroy' => 'preisuntergrenze.destroy'
]); 

//Innerbetriebliche Leistungsverrechnung
Route::get('/AA', function () {
    return Inertia::render('GanzeAbweichungsanalyse');
})->middleware(['auth', 'verified'])->name('GanzeAbweichungsanalyse');

// Define additional routes if needed
//Route::get('/abweichungsanalyse-tabelle', [AbweichungsanalysenController::class, 'showTable'])->name('abweichungsanalyse.table');
//Route::get('/abweichungsanalyse', [AbweichungsanalysenController::class, 'show'])->name('abweichungsanalyse.index');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
