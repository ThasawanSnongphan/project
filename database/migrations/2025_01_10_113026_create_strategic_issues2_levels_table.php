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
        Schema::create('strategic_issues2_levels', function (Blueprint $table) {
            $table->id('SFA2LVID');
            $table->string('name');
            $table->unsignedBigInteger('stra2LVID');
            $table->foreign('stra2LVID')->references('stra2LVID')->on('strategic2_levels')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('strategic_issues2_levels');
    }
};
