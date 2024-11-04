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
        Schema::create('k_p_i_project_maps', function (Blueprint $table) {
            $table->id('KPIProMap');
            $table->unsignedBigInteger('KPIProID');
            $table->foreign('KPIProID')->references('KPIProID')->on('k_p_i_projects')->onDelete('cascade'); 
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
        Schema::dropIfExists('k_p_i_project_maps');
    }
};
