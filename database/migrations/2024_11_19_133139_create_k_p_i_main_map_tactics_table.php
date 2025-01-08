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
        Schema::create('k_p_i_main_map_tactics', function (Blueprint $table) {
            $table->id('MapID');
            $table->unsignedBigInteger('KPIMainID');
            $table->foreign('KPIMainID')->references('KPIMainID')->on('k_p_i_mains')->onDelete('cascade');
            $table->unsignedBigInteger('tacID');
            $table->foreign('tacID')->references('tacID')->on('tactics')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('k_p_i_main_map_tactics');
    }
};
