<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [
        'name', 
        'slug',
        'category_id',
        'is_active',
];

   public function getPhotoUrlAttribute(){
        return asset($this->photo
            ? 'uploads/SubCategoryPhotos/' . $this->photo
            : 'uploads/general/no_image.png');
    }

    public function business_listings()
    {
        return $this->belongsToMany(BusinessListing::class, 'business_listing_sub_category');
    }

    public function category()
    {

        return $this->belongsTo(Category::class);
    }

    public function scopeActive($query){

        return $query->where('is_active', true);
        
    }
}
