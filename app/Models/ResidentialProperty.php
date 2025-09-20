<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResidentialProperty extends Model
{
    use HasFactory;
    protected $fillable = [
        'property_id','bedrooms','bathrooms','floor_area','lot_size','year_built',
        'floors','parking_spaces','balcony','heating_cooling','amenities'
    ];
    
    public function property(){
        return $this->belongsTo(PropertyAd::class, 'property_id','id');
    }
}
