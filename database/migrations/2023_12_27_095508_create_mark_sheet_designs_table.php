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
        Schema::create('mark_sheet_designs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->foreign('school_id')->references('id')->on('schools');
            $table->string('template');
            // $table->string('heading');
            // $table->string('title');
            $table->string('exam_name');
            $table->string('left_logo');
            $table->string('right_logo');
            // $table->string('school_name');
            $table->string('exam_center');
            // $table->string('exam_session')->nullable();
            $table->string('left_sign')->nullable();
            $table->string('middle_sign')->nullable();
            $table->string('right_sign')->nullable();
            $table->string('background_img')->nullable();
            // $table->string('date')->nullable();
            $table->boolean('is_classteacher_remarks')->default(0)->comment('0 => no, 1 => yes');
            $table->boolean('is_name')->default(0)->comment('0 => no, 1 => yes');
            $table->boolean('is_father_name')->default(0)->comment('0 => no, 1 => yes');
            $table->boolean('is_mother_name')->default(0)->comment('0 => no, 1 => yes');
            $table->boolean('is_dob')->default(0)->comment('0 => no, 1 => yes');
            $table->boolean('is_admission_no')->default(0)->comment('0 => no, 1 => yes');
            $table->boolean('is_roll_no')->default(0)->comment('0 => no, 1 => yes');
            $table->boolean('is_address')->default(0)->comment('0 => no, 1 => yes');
            $table->boolean('is_gender')->default(0)->comment('0 => no, 1 => yes');
            $table->boolean('is_division')->default(0)->comment('0 => no, 1 => yes');
            $table->boolean('is_rank')->default(0)->comment('0 => no, 1 => yes');
            $table->boolean('is_custom_field')->default(0)->comment('0 => no, 1 => yes');
            $table->boolean('is_photo')->default(0)->comment('0 => no, 1 => yes');
            $table->boolean('is_class')->default(0)->comment('0 => no, 1 => yes');
            $table->boolean('is_session')->default(0)->comment('0 => no, 1 => yes');
            $table->string('content')->nullable();
            $table->string('content_footer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mark_sheet_designs');
    }
};
