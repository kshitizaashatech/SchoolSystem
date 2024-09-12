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
        Schema::create('fee_collections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fee_groups_types_id');
            $table->foreign('fee_groups_types_id')->references('id')->on('fee_groups_types')->cascadeOnDelete();

            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('students')->cascadeOnDelete();;

            $table->integer('amount');
            $table->date('payed_on');
            $table->string('payment_mode_id');
            $table->string('notes');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_collections');
    }
};
