<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = ['product_name', 'product_price', 'member_id', 'available'];

    public function member()
    {
        return $this->belongsTo('App\Member');
    }
    public function channel()
    {
        return $this->hasOne('App\Channel');
    }
    public function transaction()
    {
        return $this->hasOne("App\Transaction");
    }
}
