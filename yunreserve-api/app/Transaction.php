<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = ['buyer_id', 'product_id'];

    public function buyer(){
        return $this->belongsTo('App\Member');
    }
    public function product(){
        return $this->belongsTo('App\Product');
    }
}
