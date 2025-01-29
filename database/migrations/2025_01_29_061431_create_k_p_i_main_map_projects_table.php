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
        Schema::create('k_p_i_main_map_projects', function (Blueprint $table) {
            $table->id('KPIMainmapProjectID');
            $table->unsignedBigInteger('KPIMainID');
            $table->foreign('KPIMainID')->references('KPIMainID')->on('k_p_i_mains')->onDelete('cascade');
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
        Schema::dropIfExists('k_p_i_main_map_projects');
    }
};
