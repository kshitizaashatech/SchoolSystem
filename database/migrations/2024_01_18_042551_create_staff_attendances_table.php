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
        Schema::create('staff_attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('biometric_attendance')->nullable();
            $table->unsignedBigInteger('attendance_type_id');
            $table->string('remarks')->nullable();
            $table->boolean('is_active')->nullable();
            $table->string('date');
            $table->string('role');
            $table->timestamps();

            $table->foreign('attendance_type_id')->references('id')->on('attendance_types');
            $table->foreign('school_id')->references('id')->on('schools');
            $table->foreign('staff_id')->references('id')->on('staffs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_attendances');
    }
};
