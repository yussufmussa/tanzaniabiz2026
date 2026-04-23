<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    protected $fillable = [
        'name',
        'is_active',
    ];

    public function business_listing()
    {

        return $this->belongsToMany(BusinessListing::class)
                                    ->withPivot('link')
                                    ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
