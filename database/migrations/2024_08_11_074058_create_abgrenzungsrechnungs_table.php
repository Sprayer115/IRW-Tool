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
        Schema::create('abgrenzungsrechnungs', function (Blueprint $table) {
            $table->id();
            $table->double('aufwand')->nullable();
            $table->double('zeitliche_abgrenzung')->nullable();
            $table->double('za_aw')->nullable();
            $table->double('sachliche_abgrenzung')->nullable();
            $table->double('kosten')->nullable();
            $table->integer('zeitraum');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abgrenzungsrechnungs');
    }
};
