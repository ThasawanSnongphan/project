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
        Schema::create('k_p_i_main2_levels', function (Blueprint $table) {
            $table->id('KPIMain2LVID');
            $table->string('name');
            $table->string('count');
            $table->string('target');
            $table->unsignedBigInteger('SFA2LVID');
            $table->foreign('SFA2LVID')->references('SFA2LVID')->on('strategic_issues2_levels')->onDelete('cascade');
            $table->unsignedBigInteger('directorID');
            $table->foreign('directorID')->references('userID')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('recorderID');
            $table->foreign('recorderID')->references('userID')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('k_p_i_main2_levels');
    }
};
