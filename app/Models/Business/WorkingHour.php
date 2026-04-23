<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;

class WorkingHour extends Model
{
    protected $guarded = [];

    public function business_listing(){
        return $this->belongsTo(BusinessListing::class);
    }
}
