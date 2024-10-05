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
        Schema::create('k_p_i_mains', function (Blueprint $table) {
            $table->id('KPIMainID');
            $table->string('name');
            $table->string('count');
            $table->string('target');
            $table->unsignedBigInteger('TacID');
            $table->foreign('TacID')->references('TacID')->on('tactics')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('k_p_i_mains');
    }
};
