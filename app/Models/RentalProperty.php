<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentalProperty extends Model
{
    protected $fillable = [
        'property_id','rent_frequency','rent_amount','deposit_amount',
        'lease_term','available_from','furnished','utilities_included','other_conditions'
    ];
    
    public function property(){
        return $this->belongsTo(PropertyAd::class, 'property_id','id');
    }
}
