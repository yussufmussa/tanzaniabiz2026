<?php

namespace App\Models\Jobs;

use Illuminate\Database\Eloquent\Model;

class JobType extends Model
{
    protected $fillable = [ 
        'name',
        'slug',
    ];

    public function jobs() {

        return $this->hasMany(PostJob::class);
    }
}
