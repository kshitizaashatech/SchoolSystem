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
        Schema::create('student_attendances', function (Blueprint $table) {
            $table->id();
            $table->integer('biometric_attendance')->nullable(); //NEEDED WHEN IMPLEMENTING BIOMETRIC ATTENDANCE
            $table->unsignedBigInteger('attendance_type_id');
            $table->unsignedBigInteger('student_session_id');
            $table->string('date');
            $table->string('remarks')->nullable();
            // $table->boolean('is_active')->default(0)->comment('0=>no, 1=>yes');
            $table->timestamps();

            $table->foreign('attendance_type_id')->references('id')->on('attendance_types');
            $table->foreign('student_session_id')->references('id')->on('student_sessions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_attendances');
    }
};
