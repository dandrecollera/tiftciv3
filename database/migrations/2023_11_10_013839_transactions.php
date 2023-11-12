<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Transactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('amount');
            $table->unsignedBigInteger('userid');
            $table->boolean('voucher')->default(false);
            $table->boolean('tuition')->default(false);
            $table->boolean('registration')->default(false);
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
        Schema::dropIfExists('transactions');
    }
}
