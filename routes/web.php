<?php

use App\Http\Controllers\AbgrenzungsrechnungController;
use App\Http\Controllers\AbweichungsanalysenController;
use App\Http\Controllers\TabelleAbweichungsanalysenController;
use App\Http\Controllers\BreakEvensController;
use App\Http\Controllers\DeckungsbeitragController;
use App\Http\Controllers\PreisuntergrenzenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('dashboard');
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

// abweichungsanalyse tabelle
Route::resource('abweichungsanalysetabelle', TabelleAbweichungsanalysenController::class)->only([
    'index', 'store', 'destroy'
])->middleware(['auth', 'verified'])->names([
    'index' => 'tabelleabweichungsanalyse.index',  // Ensure correct naming here
    'store' => 'tabelleabweichungsanalyse.store',
    'destroy' => 'tabelleabweichungsanalyse.destroy'
]);

//Make-or-Buy
Route::get('/make-or-buy', function () {
    return Inertia::render('MakeOrBuy');
})->middleware(['auth', 'verified'])->name('makeOrBuy');

//Innerbetriebliche Leistungsverrechnung
Route::get('/iblv', function () {
    return Inertia::render('Calc/InnerbetrieblicheLeistungsverrechnung');
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
Route::get('/getAbweichungsrechnungTabelle', [TabelleAbweichungsanalysenController::class, 'getAbweichungsrechnungTabelle'])->name('getAbweichungsrechnungTabelle');
Route::get('/getPreisuntergrenze', [PreisuntergrenzenController::class, 'getPreisuntergrenze'])->name('getPreisuntergrenze');

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

//OptimalesProduktionsprogramm
Route::get('/OPP', function () {
    return Inertia::render('OptimalesProduktionsProgramm');
})->middleware(['auth', 'verified'])->name('OptimalesProduktionsProgramm');

// Define additional routes if needed
//Route::get('/abweichungsanalyse-tabelle', [AbweichungsanalysenController::class, 'showTable'])->name('abweichungsanalyse.table');
//Route::get('/abweichungsanalyse', [AbweichungsanalysenController::class, 'show'])->name('abweichungsanalyse.index');


//Maschinenstundensatzrechnung
Route::get('/Maschinenstundensatzrechnung', function () {
    return Inertia::render('Maschinenstundensatzrechnung');
})->middleware(['auth', 'verified'])->name('Maschinenstundensatzrechnung');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');



// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::get('/finanzbuchhaltung', function (Request $request) {
        return Inertia::render('TopicLayout', [
            'topicId' => 'finanzbuchhaltung',
            'title' => 'Finanzbuchhaltung',
            'page' => $request->query('page', '1')
        ]);
    })->name('finanzbuchhaltung');
    
    Route::get('/kostenarten', function (Request $request) {
        return Inertia::render('TopicLayout', [
            'topicId' => 'kostenarten',
            'title' => 'Kostenarten',
            'page' => $request->query('page', '1')
        ]);
    })->name('kostenarten');
    
    Route::get('/kostenstellen', function (Request $request) {
        return Inertia::render('TopicLayout', [
            'topicId' => 'kostenstellen',
            'title' => 'Kostenstellen',
            'page' => $request->query('page', '1')
        ]);
    })->name('kostenstellen');

    Route::get('/kostentraeger', function (Request $request) {
        return Inertia::render('TopicLayout', [
            'topicId' => 'kostentraeger',
            'title' => 'Kostentraeger',
            'page' => $request->query('page', '1')
        ]);
    })->name('kostentraeger');

    Route::get('/deckungsbeitrag', function (Request $request) {
        return Inertia::render('TopicLayout', [
            'topicId' => 'deckungsbeitrag',
            'title' => 'Deckungsbeitrag',
            'page' => $request->query('page', '1')
        ]);
    })->name('deckungsbeitrag');
    
    Route::get('/plankosten', function (Request $request) {
        return Inertia::render('Calc/Abweichungsanalyse');
    })->name('plankosten');
    
    // Add other topic routes
});

require __DIR__.'/auth.php';
