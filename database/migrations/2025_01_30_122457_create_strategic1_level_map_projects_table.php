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
        Schema::create('strategic1_level_map_projects', function (Blueprint $table) {
            $table->id('stra1LVMapProID');
            $table->unsignedBigInteger('stra1LVID');
            $table->foreign('stra1LVID')->references('stra1LVID')->on('strategic1_levels')->onDelete('cascade');
            $table->unsignedBigInteger('tar1LVID');
            $table->foreign('tar1LVID')->references('tar1LVID')->on('target1_levels')->onDelete('cascade');
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
        Schema::dropIfExists('strategic1_level_map_projects');
    }
};
