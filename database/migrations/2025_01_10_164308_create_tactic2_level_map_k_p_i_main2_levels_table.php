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
        Schema::create('tactic2_level_map_k_p_i_main2_levels', function (Blueprint $table) {
            $table->id('Map2LVID');
            $table->unsignedBigInteger('tac2LVID');
            $table->foreign('tac2LVID')->references('tac2LVID')->on('tactic2_levels')->onDelete('cascade');
            $table->unsignedBigInteger('KPIMain2LVID');
            $table->foreign('KPIMain2LVID')->references('KPIMain2LVID')->on('k_p_i_main2_levels')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tactic2_level_map_k_p_i_main2_levels');
    }
};
