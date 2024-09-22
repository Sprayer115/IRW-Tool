<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreakEvens extends Model
{
    protected $table = 'breakevens';

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
