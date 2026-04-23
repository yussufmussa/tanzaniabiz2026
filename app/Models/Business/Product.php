<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function business_listing(){

        return $this->belongsTo(BusinessListing::class);
        
    }
}
