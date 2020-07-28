<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = ['id','product_name', 'product_price','member_id'];

    public function member()
    {
        return $this->belongsTo('App\Member');
    }

}
