<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcaActivityClassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eca_activity_class', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('eca_activity_id');
            $table->unsignedBigInteger('class_id');
            $table->timestamps();

            $table->foreign('eca_activity_id')->references('id')->on('eca_activities')->onDelete('cascade');
            $table->foreign('class_id')->references('id')->on('classes')->onDelete('cascade');

            $table->unique(['eca_activity_id', 'class_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eca_activity_class');
    }
}