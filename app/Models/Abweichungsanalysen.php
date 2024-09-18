<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abweichungsanalysen extends Model
{
    protected $table = 'abweichungsanalysen';

    protected $fillable = [
        'beschaeftAbweichung',
        'fixkosten',
        'gesamtabweichung',
        'istKosten',
        'istKostenVerechneteLeistung',
        'istLeistung',
        'sollKosten',
        'varPlanverrechnungssatz',
        'verbrauchsabweichung',
    ];
}
