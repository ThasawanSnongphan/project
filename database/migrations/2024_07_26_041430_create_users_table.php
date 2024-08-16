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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('UserName');
            $table->string('Email');
            $table->string('Password');
            $table->string('account_type');
            $table->string('full_prefix_name_th');
            $table->string('firstname_th');
            $table->string('lastname_th');
            $table->string('firstname_en');
            $table->string('lastname_en');
            $table->Integer('personnel_type_id');
            $table->string('personnel_type_name');
            $table->Integer('position_id');
            $table->string('position_name');
            $table->Integer('position_type_id');
            $table->string('position_type_th');
            $table->Integer('faculty_code');
            $table->string('faculty_name');
            $table->boolean('Executive');
            $table->boolean('Planning_Analyst');
            $table->boolean('Department_head');
            $table->boolean('Supply_Analyst');
            $table->boolean('Responsible');
            $table->boolean('Admin');
            $table->boolean('flag');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
