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
            $table->text('major_incidents')->nullable();
            $table->text('major_work_observation')->nullable();
            $table->text('assembly_management')->nullable();
            $table->text('miscellaneous')->nullable();
            $table->text('logged_date')->nullable();
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
