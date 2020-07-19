<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    //
    protected $fillable = ['id','product_id'];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
