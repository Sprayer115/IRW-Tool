<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plankostenrechnung extends Model
{

    protected $table = 'plankostenrechnungen';

    protected $fillable = [
        'plankosten_variabel',
        'plankosten_gesamt',
        'istkosten',
        'stueck_soll',
        'stueck_ist',
    ];
}
