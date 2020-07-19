<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
    protected $fillable = ['id','member_name', 'member_account','member_password',"member_email","member_phone","member_bankCode","member_bankAccount","verify"];

    public function products()
    {
        return $this->hasMany('App\Product');
    }
    public function transactions()
    {
        return $this->hasMany("App\Transaction");
    }

}
