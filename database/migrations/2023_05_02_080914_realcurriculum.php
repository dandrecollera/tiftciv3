<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Realcurriculum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('realcurriculums', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->json('cstt');
            $table->string('schoolyear');
            $table->string('yearlevel');
            $table->string('strand');
            $table->string('semester');
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('realcurriculums');
    }
}
