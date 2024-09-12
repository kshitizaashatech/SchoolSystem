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
        Schema::create('staffs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('school_id');
            $table->foreign('school_id')->references('id')->on('schools');

            $table->string('employee_id')->nullable();

            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments');

            $table->string('qualification')->nullable();
            $table->string('work_experience')->nullable();
            $table->boolean('marital_status')->nullable();
            $table->string('date_of_joining')->nullable();
            $table->string('date_of_leaving')->nullable();
            $table->string('payscale')->nullable();
            $table->string('basic_salary')->nullable();
            $table->string('contract_type')->nullable();
            $table->string('shift')->nullable();
            $table->string('location')->nullable();
            $table->string('resume')->nullable();
            $table->string('joining_letter')->nullable();
            $table->string('resignation_letter')->nullable();
            $table->string('medical_leave')->nullable();
            $table->string('casual_leave')->nullable();
            $table->string('maternity_leave')->nullable();
            $table->string('other_document')->nullable();
            $table->string('role')->nullable();
            $table->boolean('is_active')->default(1)->comment('0=>no, 1=>yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staffs');
    }
};