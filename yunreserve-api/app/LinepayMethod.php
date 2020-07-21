<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinepayMethod extends Model
{
    protected $fillable = ['id','method','amount','line_pay_id'];
    public function linepay()
    {
        return $this->belongsTo('App\Line_pay');
    }
}
