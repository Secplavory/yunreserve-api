<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinePaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_pays', function (Blueprint $table) {
            $table->increments('id');
            $table->string('returnCode', 4);
            $table->string('returnMessage', 100);
            $table->string('transactionId', 19);
            $table->string('orderId', 100);
            $table->string('transactionDate', 20);
            $table->integer('method_id');
            $table->string('balance', 38);
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
        Schema::dropIfExists('line_pays');
    }
}
