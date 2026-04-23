<?php

namespace App\Models\Jobs;

use App\Models\Business\City;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PostJob extends Model
{
    protected $fillable = [
        'title',
        'user_id',
        'job_sector_id',
        'job_type_id',
        'job_opening_date',
        'job_closing_date',
        'description',
        'no_to_employed',
        'city_id',
    ];

    protected $casts = [
        'job_opening_date' => 'date',
        'job_closing_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobType()
    {

        return $this->belongsTo(JobType::class, 'job_type_id');
    }

    public function jobSector()
    {

        return $this->belongsTo(JobSector::class, 'job_sector_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
