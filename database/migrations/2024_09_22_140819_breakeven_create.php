<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('breakevens', function (Blueprint $table) {
            $table->id();
            $table->double('stueckPreis');
            $table->double('geplantePMenge');
            $table->double('KTZrechnung');
            $table->double('deckungsBeitrag');
            $table->double('varKosten');
            $table->double('fixkosten');
            $table->double('opErgebnis');
            $table->double('deckungsBeitragProStueck');
            $table->double('breakEvenMenge');
            $table->double('breakEvenUmsatz');
            $table->double('stueckkosten');
            $table->timestamps(); // Erstellt die Felder created_at und updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('breakevens');
    }
};
