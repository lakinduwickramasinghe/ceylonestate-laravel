<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyImage extends Model
{
    use HasFactory;
    protected $fillable = ['property_id','imagepath','order','is_main'];

    public function property(){
        return $this->belongsTo(PropertyAd::class, 'property_id','id');
    }
}
