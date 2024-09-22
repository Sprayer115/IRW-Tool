<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreakEvens extends Model
{
    protected $table = 'breakeven';

    protected $fillable = [
        'stueckPreis',
        'geplantePMenge',
        'KTZrechnung',
        'deckungsBeitrag',
        'varKosten',
        'fixkosten',
        'opErgebnis',
    ];
}
