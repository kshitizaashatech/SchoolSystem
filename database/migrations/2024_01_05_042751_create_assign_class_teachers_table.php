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
        Schema::create('assign_class_teachers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_session_id');
            $table->foreign('academic_session_id')->references('id')->on('academic_sessions');

            $table->unsignedBigInteger('class_id');
            $table->foreign('class_id')->references('id')->on('classes');

            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')->on('sections');



            // $table->unsignedBigInteger('class_teacher_id');
            // $table->foreign('class_teacher_id')->references('id')->on('class_teachers');

            $table->boolean('is_active')->default(0)->comment('0 => no, 1 => yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assign_class_teachers');
    }
};
