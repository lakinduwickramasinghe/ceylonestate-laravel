<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory;
    
    protected $connection = 'mongodb'; 
    protected $collection = 'feedback';

    protected $fillable = [
        'userid',
        'rating',
        'message',
    ];
}
