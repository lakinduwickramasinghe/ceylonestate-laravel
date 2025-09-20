<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LandProperty extends Model
{
    use HasFactory;
    protected $fillable = [
        'property_id','land_size','zoning','road_frontage','utilities','soil_type'
    ];
    
    public function property(){
        return $this->belongsTo(PropertyAd::class, 'property_id','id');
    }
}
