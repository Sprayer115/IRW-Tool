<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TabelleAbweichungsanalysen extends Model
{
    protected $table = 'tabelleabweichungsanalysen';

    protected $fillable = [
        'varSummeKosten',
        'geplanteLeistung',
        'IstLeistung',
        'SummeIstKosten',
        'verrechneteLeistungGesamt',
        'varPlanverrechnungssatz',
        'gesPlanverrechnungssatz',
        'verrechneteLeistungIst',
        'abweichung',
        'IstKostensatz',
    ];
}
