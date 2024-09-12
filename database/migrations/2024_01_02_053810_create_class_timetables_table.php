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
        Schema::create('class_timetables', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('academic_session_id');
            // $table->foreign('academic_session_id')->references('id')->on('academic_sessions');

            // $table->unsignedBigInteger('school_id');
            // $table->foreign('school_id')->references('id')->on('schools');

            // $table->unsignedBigInteger('class_id');
            // $table->foreign('class_id')->references('id')->on('classes');

            // $table->unsignedBigInteger('section_id');
            // $table->foreign('section_id')->references('id')->on('sections');

            // $table->unsignedBigInteger('subject_id');
            // $table->foreign('subject_id')->references('id')->on('subjects');

            // $table->unsignedBigInteger('staff_id');
            // $table->foreign('staff_id')->references('id')->on('staff');

            $table->string('day');
            $table->date('time_from');
            $table->date('time_to');
            $table->date('start_time')->nullable();
            $table->date('end_time')->nullable();
            $table->string('room_no');
            $table->boolean('is_active')->default(0)->comment('0 => no, 1 => yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_timetables');
    }
};