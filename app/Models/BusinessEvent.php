<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessEvent extends Model
{
    protected $guarded = [];

    public function user(){

        return $this->belongsTo(User::class);

    }

    protected $casts = [
        'starting_date' => 'date',
        'closing_date' => 'date',

        'starting_time' => 'datetime',
        'ending_time' => 'datetime',
    ];

}
