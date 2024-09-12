<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('student_session_id');
            $table->foreign('student_session_id')->references('id')->on('student_sessions');

            $table->unsignedBigInteger('exam_student_id');
            $table->foreign('exam_student_id')->references('id')->on('exam_students');

            $table->unsignedBigInteger('exam_schedule_id');
            $table->foreign('exam_schedule_id')->references('id')->on('exam_schedules');

            $table->unsignedBigInteger('subject_id');

            $table->string('attendance')->nullable();
            $table->string('participant_assessment')->nullable();
            $table->string('practical_assessment')->nullable();
            $table->string('theory_assessment')->nullable();
            $table->string('notes')->nullable();
            $table->boolean('is_active')->default(0)->comment('0 => no, 1 => yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_results');
    }
};