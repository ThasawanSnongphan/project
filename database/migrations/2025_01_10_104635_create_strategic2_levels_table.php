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
        Schema::create('strategic2_levels', function (Blueprint $table) {
            $table->id('stra2LVID');
            $table->string('name');
            $table->unsignedBigInteger('yearID');
            $table->foreign('yearID')->references('yearID')->on('years')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('strategic2_levels');
    }
};
