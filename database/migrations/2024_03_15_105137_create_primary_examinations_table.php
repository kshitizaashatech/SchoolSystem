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
        Schema::create('primary_examinations', function (Blueprint $table) {
            $table->id();
            $table->string('exam');
            $table->unsignedBigInteger('session_id');
            $table->foreign('session_id')->references('id')->on('academic_sessions');
            $table->unsignedBigInteger('school_id')->nullable();
            $table->foreign('school_id')->references('id')->on('schools');
            $table->boolean('is_publish')->default(0)->comment('0 => no, 1 => yes');
            $table->boolean('is_rank_generated')->default(0)->comment('0 => no, 1 => yes');
            $table->boolean('is_active')->default(0)->comment('0 => no, 1 => yes');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('primary_examinations');
    }
};
