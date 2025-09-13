<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndustrialProperty extends Model
{
    protected $fillable = [
        'property_id','total_area','power_capacity','ceiling_height',
        'floor_load_capacity','crane_availability','access_roads',
        'waste_disposal','safety_certifications'
    ];

    public function property(){
        return $this->belongsTo(PropertyAd::class, 'property_id','id');
    }
}
