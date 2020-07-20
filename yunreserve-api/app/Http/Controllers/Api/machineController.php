<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Channel;
use App\Product;
use App\Member;
use App\Transaction;
use App\Taiwan_pay;

use Mail;


class machineController extends Controller
{
    //
    public function getChannalStatus(Request $request, $channelId=null)
    {
        if($channelId==null){
            $status = Channel::all();
        }else{
            $status = Channel::find($channelId);
        }
        return $status;
    }

    public function getProduct(Request $request, $channelId)
    {
        $product = Channel::find($channelId)->product;
        return $product;
    }

    public function launch(Request $request)
    {
        $securityCode = $request->input('securityCode');
        if(strcmp($securityCode, "OFA82497653@")==0){
            $product_name = $request->input('product_name');
            $product_price = $request->input('product_price');
            $channelId = $request->input('channelId');
            $memberId = $request->input('memberId');

            $product = Product::create([
                "product_name"=>$product_name,
                "product_price"=>$product_price,
                "member_id"=>$memberId
                ]);
            
            $channel = Channel::find($channelId);
            $channel->product()->associate($product);
            $channel->save();
            return "true";
        }else{
            return "false";
        }
    }

    public function login(Request $request)
    {
        $securityCode = $request->input('securityCode');
        if(strcmp($securityCode, "OFA82497653@")==0){
            $member_account = $request->input('member_account');
            $member_password = $request->input('member_password');
            $member = Member::where('member_account',$member_account)->first();
            if($member == null){
                return "0";
            }
            if($member->member_password == hash('sha256', $member_password)){
                if($member->verify=="1"){
                    return $member->id;
                }else{
                    return "-4";
                }
            }else{
                return '0';
            }
        }else{

            return "0";

        }
    }

    public function recall(Request $request)
    {
        $securityCode = $request->input('securityCode');
        if(strcmp($securityCode, "OFA82497653@")==0){
            $channelId = $request->input('channelId');
            $channel = Channel::find($channelId);
            $channel->product_id = 0;
            $channel->save();
            return "true";
        }else{
            return "false";
        }
    }

    public function productOwner(Request $request)
    {
        $securityCode = $request->input('securityCode');
        if(strcmp($securityCode, "OFA82497653@")==0){
            $memberId = $request->input("memberId");
            $member = Member::find($memberId);
            $products = $member->products;
            $channelId_array = [];
            foreach($products as $product){
                $channel = $product->channel;
                if($channel != null){
                    array_push($channelId_array, $channel["id"]);
                }
            }
            return $channelId_array;
        }else{
            return "0";
        }
    }

    public function getSignupQRcode(Request $request)
    {
        return "https://sinshengcci.com/yunreserve/member/sign-up/";
    }
    public function getChangeMemberInfoQRcode(Request $request)
    {
        return "https://sinshengcci.com/yunreserve/member/change-info/";
    }
    public function getForgetMemberQRcode(Request $request)
    {
        return "https://sinshengcci.com/yunreserve/member/forget-password/";
    }
    public function getContractQRcode()
    {
        return "https://sinshengcci.com/yunreserve/about/privacy-policy/";
    }

    public function check_TWpay(Request $request)
    {
        $securityCode = $request->input("securityCode");
        if(strcmp($securityCode, "OFA82497653@")!=0){
            return "false";
        }
        $orderNumber = $request->input("orderNumber");
        $product_price = $request->input("product_price");
        $product_price = $product_price."00";
        $product_price = str_pad($product_price, 12, "0", STR_PAD_LEFT);
        $tw_pay = Taiwan_pay::where([
                ["orderNumber", "=", $orderNumber],
                ["amt", "=", $product_price],
                ["used", "=", "0"]
            ])->first();
        if($tw_pay==null){
            return "false";
        }
        $tw_pay->used = "1";
        $tw_pay->save();
        $channelId = $request->input("channelId");
        $channel = Channel::find($channelId);
        $product = $channel->product;
        $channel->product_id = "0";
        $channel->save();
        Transaction::create([
            "product_id" => $product->id
        ]);
        $this->selled_notify($product);
        return "true";
    }

    public function selled_notify($product){
        $from = [
            "email"=>"yunreserve@gmail.com",
            "name" =>"芯生文創",
            "subject"=>"商品售出通知"
        ];
        $member = $product->member;
        $receiver_email = $member->member_email;
        $receiver_name = $member->member_name;
        $receiver_bankCode = $member->member_bankCode;
        $receiver_bankAccount = $member->member_bankAccount;
        $to = [
            "email"=>$receiver_email,
            "name"=>$receiver_name
        ];
        $price = $product->product_price;
        if($price<100){
            $fee = 10;
        }else if($price<1000){
            $fee = $price * 0.1;
        }else{
            $fee = 100 + ($price - 1000)*0.05;
        }
        $fee = floor($fee);
        $data = [
            "bankCode"=>$receiver_bankCode,
            "bankAccount"=>$receiver_bankAccount,
            "product"=>$product->product_name,
            "price"=>$price,
            "fee"=>$fee,
            "subject"=>"芯生文創－商品售出通知",
            "msg"=>"販售金額將匯入銀行帳戶"
        ];
        Mail::send("emails.selled_seller", $data, function($message) use ($from, $to){
            $message->from($from['email'], $from['name']);
            $message->to($to['email'], $to['name'])->subject($from['subject']);
        });
    }


    // public function createChannels(){

    //     for($x = 0; $x <28; $x++){
    //         $ch = new Channel;
    //         $ch->status = "0";
    //         $ch->save();
    //     }
    //     return 'successed';
    // }
}

