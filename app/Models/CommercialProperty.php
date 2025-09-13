<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommercialProperty extends Model
{
    protected $fillable = [
        'property_id','floor_area','number_of_floors','parking_spaces','power_capacity',
        'business_type','loading_docks','conference_rooms','accessibility_features'
    ];

    public function property(){
        return $this->belongsTo(PropertyAd::class, 'property_id','id');
    }
}
