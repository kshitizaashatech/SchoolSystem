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
        Schema::create('primary_exam_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_session_id');
            $table->foreign('student_session_id')->references('id')->on('student_sessions');

            $table->unsignedBigInteger('exam_schedule_id');
            $table->foreign('exam_schedule_id')->references('id')->on('primary_exam_schedules');

            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('lesson_id');

            $table->string('attendance')->nullable();
            $table->string('marks')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('primary_exam_results');
    }
};
