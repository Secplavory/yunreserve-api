<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Channel;
use Carbon\Carbon;

class adminController extends Controller
{
    public function viewChannels(Request $request){
        $channels = Channel::all();
        $ch_arr = [];
        foreach($channels as $channel){
            if($channel->product_id != "0"){
                $product_name = $channel->product->product_name;
            }else{
                $product_name = "---";
            }
            array_push($ch_arr, [
                "id"=>$channel->id,
                "product_name"=>$product_name,
                "updated_at"=>$channel->updated_at->format("Y.m.d"),
                "recalled_at"=>$channel->updated_at->parse("next sunday")->format('Y.m.d')
            ]);
        }
        $ch_arr = json_encode($ch_arr);

        return $ch_arr;
    }
}
