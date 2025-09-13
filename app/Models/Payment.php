<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['amount','remarks','user_id','property_ads'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
