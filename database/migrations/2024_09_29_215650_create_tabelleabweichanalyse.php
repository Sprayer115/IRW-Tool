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
        Schema::create('tabelleabweichungsanalysen', function (Blueprint $table) {
            $table->id();
            $table->string('varSummeKosten');
            $table->double('geplanteLeistung');
            $table->double('IstLeistung');
            $table->double('SummeIstKosten');
            $table->double('verrechneteLeistungGesamt');
            $table->double('varPlanverrechnungssatz');
            $table->double('gesPlanverrechnungssatz');
            $table->double('verrechneteLeistungIst');
            $table->double('abweichung');
            $table->double('IstKostensatz');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabelleabweichungsanalysen');
    }
};
