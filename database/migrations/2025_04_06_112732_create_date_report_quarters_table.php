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
        Schema::create('date_report_quarters', function (Blueprint $table) {
            $table->id('drqID');
            $table->date('startDate');
            $table->date('endDate');
            $table->unsignedBigInteger('quarID');
            $table->foreign('quarID')->references('quarID')->on('Quarters')->onDelete('cascade');
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
        Schema::dropIfExists('date_report_quarters');
    }
};
