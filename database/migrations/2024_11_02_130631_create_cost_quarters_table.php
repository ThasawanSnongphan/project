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
        Schema::create('cost_quarters', function (Blueprint $table) {
            $table->id('costQuID');
            $table->Integer('costQu1');
            $table->Integer('costQu2');
            $table->Integer('costQu3');
            $table->Integer('costQu4');
            $table->unsignedBigInteger('proID');
            $table->foreign('proID')->references('proID')->on('projects')->onDelete('cascade');
            $table->unsignedBigInteger('expID');
            $table->foreign('expID')->references('expID')->on('expense_badgets')->onDelete('cascade');
            $table->unsignedBigInteger('costID');
            $table->foreign('costID')->references('costID')->on('cost_Types')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cost_quarters');
    }
};
