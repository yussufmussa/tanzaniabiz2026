<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'slug',
        'is_active',
    ];

    public function subcategories()
    {

        return $this->hasMany(SubCategory::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function business_listings()
    {

        return $this->hasMany(BusinessListing::class, 'category_id');
    }

    public function getPhotoUrlAttribute()
    {
        return asset($this->photo
            ? 'uploads/categoryPhotos/' . $this->photo
            : 'uploads/general/no_image.png');
    }
}
