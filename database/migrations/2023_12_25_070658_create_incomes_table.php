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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id')->nullable();
            $table->foreign('school_id')->references('id')->on('schools');
            $table->unsignedBigInteger('incomehead_id');
            $table->foreign('incomehead_id')->references('id')->on('incomeheads');

            $table->string('name');
            $table->string('invoice_number');
            $table->date('date');
            $table->string('amount');
            $table->string('description');
            $table->string('document')->nullable();
            $table->boolean('is_active')->default(0)->comment('0=>no, 1=>yes');
            $table->timestamps();

            // Foreign keys
            // $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
