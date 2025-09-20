<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyAd extends Model
{
    use HasFactory;
    protected $fillable = [
        'title','description','property_type','price','status',
        'address_line_1','address_line_2','city','province','postal_code',
        'latitude','longitude','user_id' ];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function commercial(){
        return $this->hasOne(CommercialProperty::class, 'property_id');
    }

    public function land(){
        return $this->hasOne(LandProperty::class, 'property_id');
    }

    public function industrial(){
        return $this->hasOne(IndustrialProperty::class, 'property_id');
    }
    public function residential(){
        return $this->hasOne(ResidentialProperty::class, 'property_id');
    }

    public function images(){
        return $this->hasMany(PropertyImage::class, 'property_id');
    }

}
