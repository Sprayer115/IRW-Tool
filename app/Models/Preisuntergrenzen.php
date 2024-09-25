<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preisuntergrenzen extends Model
{
    protected $table = 'preisuntergrenzen';
    
    protected $fillable = [
        'name',
        'stueckZahl',
        'varKostenProStueck',
        'fixkosten',
        'kurzPreisUG',
        'langPreisUG'
    ];
}
