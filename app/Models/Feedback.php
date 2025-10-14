<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory;
    
    protected $connection = 'mongodb'; 
    protected $collection = 'feedback';

    
    // Query Scopes
    public function scopeActive($query){
        return $query->where('status','active');
    }

    protected $fillable = [
        'userid',
        'rating',
        'message',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }

}
