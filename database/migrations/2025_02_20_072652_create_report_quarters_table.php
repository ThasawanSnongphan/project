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
        Schema::create('report_quarters', function (Blueprint $table) {
            $table->id('reportID');
            $table->unsignedBigInteger('quarID');
            $table->foreign('quarID')->references('quarID')->on('Quarters')->onDelete('cascade');
            $table->unsignedBigInteger('proID');
            $table->foreign('proID')->references('proID')->on('projects')->onDelete('cascade');
            $table->Integer('costResult');
            $table->unsignedBigInteger('KPIMain3LVID');
            $table->foreign('KPIMain3LVID')->references('KPIMain3LVID')->on('k_p_i_main_map_projects')->onDelete('cascade');
            $table->unsignedBigInteger('KPIMain2LVID');
            $table->foreign('KPIMain2LVID')->references('KPIMain2LVID')->on('k_p_i_main2_levels')->onDelete('cascade');
            $table->unsignedBigInteger('KPIProID');
            $table->foreign('KPIProID')->references('KPIProID')->on('k_p_i_projects')->onDelete('cascade'); 
            $table->Integer('result');
            $table->string('problem');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_quarters');
    }
};
