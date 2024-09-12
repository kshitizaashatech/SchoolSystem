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
        Schema::table('head_teacher_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('school_id')->nullable()->after('id');
            $table->foreign('school_id')->references('id')->on('schools');

            $table->unsignedBigInteger('head_teacher_id')->nullable()->after('school_id');
            $table->foreign('head_teacher_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('head_teacher_logs', function (Blueprint $table) {
            $table->dropColumn(['school_id', 'head_teacher_id']);
        });
    }
};