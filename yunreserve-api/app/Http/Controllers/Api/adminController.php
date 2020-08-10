<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Channel;
use App\Transaction;
use App\Member;
use Carbon\Carbon;

class adminController extends Controller
{
    public function viewChannels(Request $request)
    {
        $securityCode = $request->input("securityCode");
        if(strcmp($securityCode, "OFA82497653@")!=0){
            return json_encode(["result"=>"0018"]);
        }
        $channels = Channel::orderBy('updated_at', 'desc')->get();
        $ch_arr = [];
        foreach($channels as $channel){
            if($channel->product_id != "0"){
                $product_name = $channel->product->product_name;
                array_push($ch_arr, [
                    "id"=>$channel->id,
                    "product_name"=>$product_name,
                    "updated_at"=>$channel->updated_at->format("Y.m.d"),
                    "recalled_at"=>$channel->updated_at->parse("next sunday")->format('Y.m.d')
                ]);
            }
        }
        $ch_arr = json_encode($ch_arr);
        return $ch_arr;
    }

    public function viewHistory(Request $request)
    {
        $securityCode = $request->input("securityCode");
        if(strcmp($securityCode, "OFA82497653@")!=0){
            return json_encode(["result"=>"0018"]);
        }
        $transactions = Transaction::orderBy('updated_at', 'desc')->get();
        $history_arr = [];
        foreach($transactions as $transaction){
            array_push($history_arr, [
                "id"=>$transaction->id,
                "product_name"=>$transaction->product_name,
                "product_price"=>$transaction->product_price,
                "member_account"=>$transaction->member->member_account,
                "selled_at"=>$transaction->updated_at->format("Y.m.d"),
            ]);
        }
        $history_arr = json_encode($history_arr);
        return $history_arr;
    }

    public function viewMember(Request $request)
    {
        $securityCode = $request->input("securityCode");
        if(strcmp($securityCode, "OFA82497653@")!=0){
            return json_encode(["result"=>"0018"]);
        }
        $members = Member::all();
        $member_records = [];
        foreach($members as $member){
            array_push($member_records, [
                "id"=>$member->id,
                "member_account"=>$member->member_account,
                "member_bankCode"=>$member->member_bankCode,
                "member_bankAccount"=>$member->member_bankAccount,
                "member_email"=>$member->member_email,
                "member_name"=>$member->member_name,
                "member_phone"=>$member->member_phone
            ]);
        }
        $member_records = json_encode($member_records);
        return $member_records;
    }

    public function viewTransfer(Request $request)
    {
        $securityCode = $request->input("securityCode");
        if(strcmp($securityCode, "OFA82497653@")!=0){
            return json_encode(["result"=>"0018"]);
        }

        $transactions = Transaction::orderBy(
            'updated_at', 'desc')->where([
                ["updated_at", '<=', Carbon::parse("last Sunday")->toDateString()],
                ["updated_at", '>', Carbon::parse("last Sunday")->subDays(7)->toDateString()]
            ])->get();
        $transfers = [];
        foreach($transactions as $transaction){
            array_push($transfers, [
                "id"=>$transaction->id,
                "product_name"=>$transaction->product_name,
                "product_price"=>$transaction->product_price,
                "member_account"=>$transaction->member->member_account,
                "selled_at"=>$transaction->updated_at->format("Y.m.d")
            ]);
        }
        $transfers = json_encode($transfers);
        return $transfers;
    }

    public function login(Request $request)
    {
        $securityCode = $request->input("securityCode");
        if(strcmp($securityCode, "OFA82497653@")==0){
            return "0000";
        }
        return "0018";
    }
}
