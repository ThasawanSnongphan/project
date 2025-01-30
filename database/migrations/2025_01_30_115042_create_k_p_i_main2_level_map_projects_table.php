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
        Schema::create('k_p_i_main2_level_map_projects', function (Blueprint $table) {
            $table->id('KPIMain2mapProjectID');
            $table->unsignedBigInteger('KPIMain2LVID');
            $table->foreign('KPIMain2LVID')->references('KPIMain2LVID')->on('k_p_i_main2_levels')->onDelete('cascade');
            $table->unsignedBigInteger('proID');
            $table->foreign('proID')->references('proID')->on('projects')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('k_p_i_main2_level_map_projects');
    }
};
