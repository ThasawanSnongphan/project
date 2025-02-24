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
        Schema::create('project_evaluations', function (Blueprint $table) {
            $table->id('evaID');
            $table->unsignedBigInteger('proID');
            $table->foreign('proID')->references('proID')->on('projects')->onDelete('cascade');    
            $table->string('statement');
            $table->string('implementation');
            $table->unsignedBigInteger('operID');
            $table->foreign('operID')->references('operID')->on('operating_results')->onDelete('cascade');  
            $table->string('since')->nullable();  
            $table->integer('badget_use');
            $table->string('benefit');
            $table->string('problem');
            $table->string('corrective_actions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_evaluations');
    }
};
