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
        Schema::table('plankostenrechnungen', function (Blueprint $table) {
            // Entferne nicht mehr benötigte Spalten
            $table->dropColumn('plankosten_variabel');
            $table->dropColumn('plankosten_gesamt');
            $table->dropColumn('istkosten');
            $table->dropColumn('stueck_soll');
            $table->dropColumn('stueck_ist');

            // Füge die neuen Spalten hinzu
            $table->integer('beschaeftAbweichung')->nullable();
            $table->integer('fixkosten')->nullable();
            $table->integer('gesamtabweichung')->nullable();
            $table->integer('istKosten')->nullable();
            $table->integer('istKostenVerechneteLeistung')->nullable();
            $table->integer('istLeistung')->nullable();
            $table->integer('sollKosten')->nullable();
            $table->integer('varPlanverrechnungssatz')->nullable();
            $table->integer('verbrauchsabweichung')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plankostenrechnungen', function (Blueprint $table) {
            // Füge die alten Spalten wieder hinzu
            $table->double('plankosten_variabel')->nullable();
            $table->double('plankosten_gesamt')->nullable();
            $table->double('istkosten')->nullable();
            $table->integer('stueck_soll')->nullable();
            $table->integer('stueck_ist')->nullable();

            // Entferne die neuen Spalten
            $table->dropColumn([
                'beschaeftAbweichung',
                'fixkosten',
                'gesamtabweichung',
                'istKosten',
                'istKostenVerechneteLeistung',
                'istLeistung',
                'sollKosten',
                'varPlanverrechnungssatz',
                'verbrauchsabweichung',
            ]);
        });
    }
};
