<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taiwan_pay extends Model
{
    //
    protected $fillable = [
        "id",
        "mti",
        "cardNumber",
        "processingCode",
        "amt",
        "systemDateTime",
        "traceNumber",
        "localTime",
        "localDate",
        "countryCode",
        "posEntryMode",
        "posConditionCode",
        "acqBank",
        "srrn",
        "terminalId",
        "merchantId",
        "orderNumber",
        "otherInfo",
        "txnCurrencyCode",
        "verifyCode",
        "orgTxnData",
        "hostId",
        "used"
    ];

}
