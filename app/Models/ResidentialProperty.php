<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResidentialProperty extends Model
{
    protected $fillable = [
        'property_id','bedrooms','bathrooms','floor_area','lot_size','year_built',
        'floors','parking_spaces','balcony','heating_cooling','amenities'
    ];
    
    public function property(){
        return $this->belongsTo(PropertyAd::class, 'property_id','id');
    }
}
