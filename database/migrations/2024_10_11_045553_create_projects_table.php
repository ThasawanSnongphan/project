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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('format');
            $table->string('PrinciDetaiil');
            $table->unsignedBigInteger('proTypeID');
            $table->foreign('proTypeID')->references('proTypeID')->on('project_types')->onDelete('cascade');
            $table->unsignedBigInteger('yearID');
            $table->foreign('yearID')->references('yearID')->on('years')->onDelete('cascade');
            $table->unsignedBigInteger('proChaID');
            $table->foreign('proChaID')->references('proChaID')->on('project_charecs')->onDelete('cascade');
            $table->unsignedBigInteger('proInID');
            $table->foreign('proInID')->references('proInID')->on('project_integrats')->onDelete('cascade');
            $table->string('ProInDetail');
            $table->unsignedBigInteger('tarID');
            $table->foreign('tarID')->references('tarID')->on('targets')->onDelete('cascade');
            $table->unsignedBigInteger('badID');
            $table->foreign('badID')->references('badID')->on('badget_types')->onDelete('cascade');
            $table->Integer('BadgetTotal');
            $table->unsignedBigInteger('planID');
            $table->foreign('planID')->references('planID')->on('uni_plans')->onDelete('cascade');
            $table->unsignedBigInteger('statusID');
            $table->foreign('statusID')->references('statusID')->on('statuses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
