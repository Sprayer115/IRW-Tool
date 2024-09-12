<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plankostenrechnungen', function (Blueprint $table) {
            $table->id();
            $table->double('plankosten_variabel');
            $table->double('plankosten_gesamt');
            $table->double('istkosten');
            $table->integer('stueck_soll');
            $table->integer('stueck_ist');
            $table->timestamps(); // Erstellt die Felder created_at und updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plankostenrechnungen');
    }
};
