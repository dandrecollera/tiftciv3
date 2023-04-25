<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MainUsersDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_users_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('userid');
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->string('mobilenumber');
            $table->longText('address');
            $table->string('photo')->default('blank.jpg');
            $table->timestamps();

            $table->foreign('userid')->references('id')->on('main_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_users_details');
    }
}
