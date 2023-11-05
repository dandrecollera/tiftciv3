<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tuition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tuition', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('userid');
            $table->unsignedBigInteger('yearid');
            $table->string('paymenttype');
            $table->string('paymentmethod');
            $table->decimal('voucher', 10, 2)->nullable();
            $table->decimal('tuition', 10, 2)->nullable();
            $table->decimal('registration', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('userid')->references('id')->on('main_users')->onDelete('cascade');
            $table->foreign('yearid')->references('id')->on('curriculums')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tuition');
    }
}
