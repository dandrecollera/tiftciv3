<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Schedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subjectid');
            $table->unsignedBigInteger('sectionid');
            $table->unsignedBigInteger('userid');
            $table->unsignedBigInteger('teacherid');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('day');
            $table->timestamps();

            // Define foreign key constraints
            $table->foreign('subjectid')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('sectionid')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('userid')->references('id')->on('main_users')->onDelete('cascade');
            $table->foreign('teacherid')->references('id')->on('teachers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
