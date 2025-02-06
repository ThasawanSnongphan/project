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
        Schema::create('strategic2_level_map_projects', function (Blueprint $table) {
            $table->id('stra2LVMapProID');
            $table->unsignedBigInteger('stra2LVID');
            $table->foreign('stra2LVID')->references('stra2LVID')->on('strategic2_levels')->onDelete('cascade');
            $table->unsignedBigInteger('SFA2LVID');
            $table->foreign('SFA2LVID')->references('SFA2LVID')->on('strategic_issues2_levels')->onDelete('cascade');
            $table->unsignedBigInteger('tac2LVID');
            $table->foreign('tac2LVID')->references('tac2LVID')->on('tactic2_levels')->onDelete('cascade');
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
        Schema::dropIfExists('strategic2_level_map_projects');
    }
};
