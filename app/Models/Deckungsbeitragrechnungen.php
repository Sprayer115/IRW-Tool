<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deckungsbeitragrechnungen extends Model
{
    protected $table = 'deckungsbeitragrechnungen';
    
    protected $fillable = [
        'name',
        'preisProStueck',
        'stueckZahl',
        'varKostenProStueck',
        'fixkosten',
        'umsatz',
        'deckungsBeitrag',
        'gewinn'
    ];
}
