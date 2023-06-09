<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Appointments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('firstname');
            $table->string('middlename')->nullable();;
            $table->string('lastname');
            $table->string('mobilenumber')->nullable();;
            $table->string('address')->nullable();;
            $table->string('graduate');
            $table->string('yearattended');
            $table->string('section')->nullable();
            $table->string('inquiry');
            $table->string('lrn');
            $table->boolean('goodmoral')->default(false);
            $table->boolean('f137')->default(false);
            $table->boolean('f138')->default(false);
            $table->boolean('diploma')->default(false);
            $table->boolean('others')->default(false);
            $table->string('otherdocument')->nullable();
            $table->text('otherreason')->nullable();
            $table->string('active')->default("Pending");
            $table->boolean('seen')->default("0");
            $table->boolean('adminseen')->default("0");
            $table->dateTime('appointeddate');
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
        Schema::dropIfExists('appointments');
    }
}
