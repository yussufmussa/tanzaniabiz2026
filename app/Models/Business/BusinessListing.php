<?php

namespace App\Models\Business;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class BusinessListing extends Model
{
    protected $guarded = [];


    public function user(){

        return $this->belongsTo(User::class);

    }
    public function scopeActive($query)
    {

        return $query->where('status', true);
    }

    public function scopeInactive($query)
    {

        return $query->where('status', false);
    }

    public function category()
    {

        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategories()
    {
        return $this->belongsToMany(SubCategory::class, 'business_listing_sub_category');
    }

    public function city()
    {

        return $this->belongsTo(City::class, 'city_id');
    }

    public function social_medias()
    {

        return $this->belongsToMany(SocialMedia::class, 'business_listing_social_media')
                                    ->withPivot('link')
                                    ->withTimestamps();
    }

    public function workingHours()
    {
        return $this->hasMany(WorkingHour::class, 'business_listing_id');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class, 'business_listing_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'business_listing_id');
    }
}
