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
        Schema::create('deckungsbeitragrechnungen', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('preisProStueck');
            $table->double('stueckZahl');
            $table->double('varKostenProStueck');
            $table->double('fixkosten');
            $table->double('umsatz');
            $table->double('deckungsBeitrag');
            $table->double('gewinn');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deckungsbeitragrechnungen');
    }
};
