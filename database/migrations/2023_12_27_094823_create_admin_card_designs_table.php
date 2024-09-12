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
        Schema::create('admin_card_designs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->foreign('school_id')->references('id')->on('schools');
            $table->string('template');
            $table->string('heading');
            $table->string('title');
            $table->string('exam_name');
            $table->string('left_logo');
            $table->string('right_logo');
            $table->string('school_name');
            $table->string('exam_center');
            $table->string('sign');
            $table->string('background_img');
            $table->boolean('is_name');
            $table->boolean('is_father_name');
            $table->boolean('is_mother_name');
            $table->boolean('is_dob');
            $table->boolean('is_admission_no');
            $table->boolean('is_roll_no');
            $table->boolean('is_address');
            $table->boolean('is_gender');
            $table->boolean('is_photo');
            $table->boolean('is_class');
            $table->boolean('is_session');
            $table->string('content_footer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_card_designs');
    }
};
