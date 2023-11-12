<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Subjectarchive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjectarchive', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('teacherid');
            $table->unsignedBigInteger('subjectid');
            $table->unsignedBigInteger('sectionid');
            $table->timestamps();

            $table->foreign('teacherid')->references('id')->on('main_users')->onDelete('cascade');
            $table->foreign('subjectid')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('sectionid')->references('id')->on('curriculums')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjectarchive');
    }
}
