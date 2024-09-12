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
        Schema::create('student_certificates', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('school_id');
            $table->foreign('school_id')->references('id')->on('schools');

            $table->string('certificate_name');
            $table->string('certificate_text');
            $table->string('left_header')->nullable();
            $table->string('central_header')->nullable();
            $table->string('right_header')->nullable();
            $table->string('left_footer')->nullable();
            $table->string('central_footer')->nullable();
            $table->string('right_footer')->nullable();
            $table->string('background_img')->nullable();
            $table->string('created_for')->nullable();
            $table->boolean('status')->default(0)->comment('0 => no, 1 => yes');
            $table->integer('header_height')->nullable();
            $table->integer('footer_height')->nullable();
            $table->integer('content_height')->nullable();
            $table->integer('content_width')->nullable();
            $table->boolean('enable_student_image')->default(0)->comment('0 => no, 1 => yes');
            $table->boolean('enable_image_height')->default(0)->comment('0 => no, 1 => yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_certificates');
    }
};
