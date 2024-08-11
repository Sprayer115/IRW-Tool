<?php

namespace Database\Seeders;

use App\Models\Abgrenzungsrechnung as ModelsAbgrenzungsrechnung;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Abgrenzungsrechnung extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsAbgrenzungsrechnung::create([
            'aufwand' => 0,
            'zeitliche_abgrenzung' => 0,
            'za_aw' => 0,
            'sachliche_abgrenzung' => 0,
            'kosten' => 0,
            'zeitraum' => 0
        ]);
    }
}
