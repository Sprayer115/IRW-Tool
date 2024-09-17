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

// abgrenzungsrechnung
Route::resource('abgrenzungsrechnung', AbgrenzungsrechnungController::class)->only([
    'index', 'store', 'destroy'
])->middleware(['auth', 'verified'])->name('index','abgrenzungsrechnung');

// plankostenrechnung
Route::resource('plankostenrechnung', PlankostenrechnungController::class)->only([
    'index', 'store', 'destroy'
])->middleware(['auth', 'verified'])->name('index','plankostenabrechnung');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
