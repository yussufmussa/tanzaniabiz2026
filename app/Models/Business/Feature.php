<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $guarded = [];

    public function packages()
    {
        return $this->belongsToMany(Package::class, 'package_features')
                    ->withPivot('value')
                    ->withTimestamps();
        
    }
}
