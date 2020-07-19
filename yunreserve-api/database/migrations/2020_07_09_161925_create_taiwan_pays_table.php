<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaiwanPaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taiwan_pays', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mti', 4);
            $table->string('cardNumber', 19);
            $table->string('processingCode', 6);
            $table->string('amt', 12);
            $table->string('systemDateTime', 10);
            $table->string('traceNumber', 6);
            $table->string('localTime', 6);
            $table->string('localDate', 8);
            $table->string('countryCode', 3);
            $table->string('posEntryMode', 3);
            $table->string('posConditionCode', 2);
            $table->string('acqBank', 3);
            $table->string('srrn', 12);
            $table->string('terminalId', 8);
            $table->string('merchantId', 15);
            $table->string('orderNumber', 19);
            $table->string('otherInfo', 999);
            $table->string('txnCurrencyCode', 3);
            $table->string('verifyCode', 64);
            $table->string('orgTxnData', 999);
            $table->string('hostId', 23);
            $table->string('used', 1);
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
        Schema::dropIfExists('taiwan_pays');
    }
}
