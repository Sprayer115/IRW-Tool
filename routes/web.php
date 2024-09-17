<?php

use App\Http\Controllers\Abgrenzungsrechnung;
use App\Http\Controllers\AbgrenzungsrechnungController;
use App\Http\Controllers\PlankostenrechnungController;
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

// Plankostenrechnung
Route::resource('plankostenrechnung', PlankostenrechnungController::class)->only([
    'index', 'store', 'destroy'
])->middleware(['auth', 'verified'])->names([
    'index' => 'plankostenrechnung.index',  // Ensure correct naming here
    'store' => 'plankostenrechnung.store',
    'destroy' => 'plankostenrechnung.destroy'
]);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
