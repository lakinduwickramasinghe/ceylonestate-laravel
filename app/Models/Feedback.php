<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Feedback extends Model
{
    protected $connection = 'mongodb'; 
    protected $collection = 'feedback';

    protected $fillable = [
        'userid',
        'rating',
        'message',
    ];
}
