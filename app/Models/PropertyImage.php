<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    protected $fillable = ['property_id','imagepath','order','is_main'];

    public function property(){
        return $this->belongsTo(PropertyAd::class, 'property_id','id');
    }
}
