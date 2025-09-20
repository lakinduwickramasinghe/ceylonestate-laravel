<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['amount','remarks','user_id','property_ads'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
