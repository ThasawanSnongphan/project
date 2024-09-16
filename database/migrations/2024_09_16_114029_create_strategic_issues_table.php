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
        Schema::create('strategic_issues', function (Blueprint $table) {
            $table->id('SFAID');
            $table->string('name');
            $table->unsignedBigInteger('straID');
            $table->foreign('straID')->references('straID')->on('strategics')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('strategic_issues');
    }
};
