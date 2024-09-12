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
        Schema::create('exam_schedules', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('examination_id');
            $table->foreign('examination_id')->references('id')->on('examinations');


            $table->unsignedBigInteger('subject_group_id');
            $table->foreign('subject_group_id')->references('id')->on('subject_groups')->onDelete('cascade')->onUpdate('cascade');
            ;

            $table->unsignedBigInteger('subject_id');
            $table->foreign('subject_id')->references('id')->on('subjects');


            $table->unsignedBigInteger('class_id');
            $table->foreign('class_id')->references('id')->on('classes');

            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')->on('sections');

            $table->string('exam_date')->nullable();
            $table->string('exam_time')->nullable();
            $table->string('exam_duration')->nullable();
            $table->string('room_no')->nullable();
            $table->integer('full_marks')->nullable();
            $table->integer('pass_marks')->nullable();
            $table->integer('credit_hour')->nullable();
            $table->boolean('is_active')->default(0)->comment('0 => no, 1 => yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_schedules');
    }
};