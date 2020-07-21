<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Line_pay extends Model
{
    protected $fillable = ['id','returnCode','returnMessage','transactionId','orderId','transactionDate','balance'];
    public function methods()
    {
        return $this->hasMany('App\LinepayMethod');
    }
}
