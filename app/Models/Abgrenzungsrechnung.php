<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abgrenzungsrechnung extends Model
{
    protected $table = 'abgrenzungsrechnungen';

    protected $fillable = [
        'aufwand',
        'zeitliche_abgrenzung',
        'za_aw',
        'sachliche_abgrenzung',
        'kosten',
        'zeitraum'
    ];

    
}
