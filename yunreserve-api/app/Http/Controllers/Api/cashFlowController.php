<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Taiwan_pay;
use \SimpleXMLElement;

class cashFlowController extends Controller
{
    //
    public function TWpay(Request $request)
    {
        $xml = $request->getContent();
        $obj = simplexml_load_string($xml);
        if($obj==null){
            return "404 not found";
        }
        $nameSpaces = $obj->getName();
        if(strcmp($nameSpaces, "QrpNotifyReq")==0){
            $json = json_encode($obj);
            $jsonArray = json_decode($json,TRUE);
            ksort($jsonArray);
            $plainText = "";
            foreach($jsonArray as $key => $val){
                if(strcmp($key, "verifyCode")!=0){
                    $plainText = $plainText.$val;
                }
            }
            $new_key = "1DD604656F0E9B59E19B2827480CD0BA";
            $plainText = $plainText.$new_key;
            $plainText_sha256 = strtoupper(hash("sha256", $plainText));
            
            $responseCode = "0000";

            if(strcmp($obj->verifyCode, $plainText_sha256)!=0){
                $responseCode = "0018";
            }
            if(strcmp($obj->merchantId, "004824976535001")!=0){
                $responseCode = "0019";
            }
            if(strcmp($obj->terminalId, "50010001")!=0){
                $responseCode = "0020";
            }
            if(strcmp($obj->hostId, "00402824976530200000001")!=0){
                $responseCode = "0019";
            }
            $mti = $obj->mti;
            $cardNumber = $obj->cardNumber;
            $processingCode = $obj->processingCode;
            $amt = $obj->amt;
            $systemDateTime = $obj->systemDateTime;
            $traceNumber = $obj->traceNumber;
            $localTime = $obj->localTime;
            $localDate = $obj->localDate;
            $countryCode = $obj->countryCode;
            $posEntryMode = $obj->posEntryMode;
            $posConditionCode = $obj->posConditionCode;
            $acqBank = $obj->acqBank;
            $srrn = $obj->srrn;
            $terminalId = $obj->terminalId;
            $merchantId = $obj->merchantId;
            $orderNumber = $obj->orderNumber;
            $otherInfo = $obj->otherInfo;
            $txnCurrencyCode = $obj->txnCurrencyCode;
            $verifyCode = $obj->verifyCode;
            $orgTxnData = $obj->orgTxnData;
            $hostId = $obj->hostId;

            $used = "0";
            if(strcmp($responseCode, "0000")!=0){
                $used = "1";
            }
            Taiwan_pay::create([
                "mti"=>$mti,
                "cardNumber"=>$cardNumber,
                "processingCode"=>$processingCode,
                "amt"=>$amt,
                "systemDateTime"=>$systemDateTime,
                "traceNumber"=>$traceNumber,
                "localTime"=>$localTime,
                "localDate"=>$localDate,
                "countryCode"=>$countryCode,
                "posEntryMode"=>$posEntryMode,
                "posConditionCode"=>$posConditionCode,
                "acqBank"=>$acqBank,
                "srrn"=>$srrn,
                "terminalId"=>$terminalId,
                "merchantId"=>$merchantId,
                "orderNumber"=>$orderNumber,
                "otherInfo"=>$otherInfo,
                "txnCurrencyCode"=>$txnCurrencyCode,
                "verifyCode"=>$verifyCode,
                "orgTxnData"=>$orgTxnData,
                "hostId"=>$hostId,
                "used"=>$used
            ]);
            
            $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><QrpNotifyResp xmlns="http://www.focas.fisc.com.tw/QRP/notify"></QrpNotifyResp>');
            $xml->addChild('mti', "0810");
            $xml->addChild('cardNumber', $cardNumber);
            $xml->addChild('processingCode', $processingCode);
            $xml->addChild('amt', $amt);
            $xml->addChild('systemDateTime', $systemDateTime);
            $xml->addChild('traceNumber', $traceNumber);
            $xml->addChild('acqBank', $acqBank);
            $xml->addChild('srrn', $srrn);
            $xml->addChild('responseCode', $responseCode);
            $xml->addChild('terminalId', $terminalId);
            $xml->addChild('merchantId', $merchantId);
            $xml->addChild('orderNumber', $orderNumber);
            $verifyCode_response = $acqBank.$amt.$cardNumber.$hostId.$merchantId."0810".$orderNumber.$processingCode.$responseCode.$srrn.$systemDateTime.$terminalId.$traceNumber;
            $verifyCode_response = $verifyCode_response.$new_key;
            $verifyCode_response_sha256 = strtoupper(hash('sha256', $verifyCode_response));
            $xml->addChild('verifyCode', $verifyCode_response_sha256);
            $xml->addChild('hostId', $hostId);
            $content = $xml->asXML();
        
            return response($content)->header('Content-Type', 'text/xml');
        }
        header("Location: https://sinshengcci.com/");
        exit();
    }

}
