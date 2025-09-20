<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = ['title','content','type','ref','is_read','user_id'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
