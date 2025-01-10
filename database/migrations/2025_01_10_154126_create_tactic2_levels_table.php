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
        Schema::create('tactic2_levels', function (Blueprint $table) {
            $table->id('tac2LVID');
            $table->string('name');
            $table->unsignedBigInteger('SFA2LVID');
            $table->foreign('SFA2LVID')->references('SFA2LVID')->on('strategic_issues2_levels')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tactic2_levels');
    }
};
