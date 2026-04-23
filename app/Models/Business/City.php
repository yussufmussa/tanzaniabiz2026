<?php

namespace App\Models\Business;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'city_name',
        'slug',
        'is_active',
    ];

    public function business_listings(){

        return $this->hasMany(BusinessListing::class, 'city_id');
        
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

     public function users(){
        return $this->hasMany(User::class);
    }
}
