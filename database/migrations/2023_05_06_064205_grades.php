<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Grades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('studentid');
            $table->unsignedBigInteger('subjectid');
            $table->unsignedBigInteger('yearid');
            $table->integer('grade');
            $table->string('quarter');
            $table->timestamps();

            $table->foreign('studentid')->references('id')->on('main_users')->onDelete('cascade');
            $table->foreign('subjectid')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('yearid')->references('id')->on('schoolyears')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grades');
    }
}
