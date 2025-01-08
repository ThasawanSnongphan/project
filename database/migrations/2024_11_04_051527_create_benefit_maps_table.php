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
        Schema::create('benefit_maps', function (Blueprint $table) {
            $table->id('bnfMapID');
            $table->unsignedBigInteger('bnfID');
            $table->foreign('bnfID')->references('bnfID')->on('benefits')->onDelete('cascade');
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
        Schema::dropIfExists('benefit_maps');
    }
};
