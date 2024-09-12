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
        Schema::create('fee_groups_types', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('fee_type_id');
            $table->foreign('fee_type_id')->references('id')->on('fee_types')->cascadeOnDelete();

            $table->unsignedBigInteger('fee_group_id');
            $table->foreign('fee_group_id')->references('id')->on('fee_groups')->cascadeOnDelete();

            // Add academic_session_id column
            $table->unsignedBigInteger('academic_session_id');
            $table->foreign('academic_session_id')->references('id')->on('academic_sessions')->cascadeOnDelete();

            // Add school_id column
            $table->unsignedBigInteger('school_id');
            $table->foreign('school_id')->references('id')->on('schools');

            $table->integer('amount');
            $table->boolean('is_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_groups_types');
    }
};
