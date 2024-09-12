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
        Schema::create('head_teacher_logs', function (Blueprint $table) {
            $table->id();
            $table->string('major_incidents')->nullable();
            $table->string('major_work_observation')->nullable();
            $table->string('assembly_management')->nullable();
            $table->string('miscellaneous')->nullable();
            $table->string('logged_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('head_teacher_logs');
    }
};
