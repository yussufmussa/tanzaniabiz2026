<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Business\BusinessListing;
use App\Models\Business\Package;
use App\Models\Jobs\PostJob;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'profile_picture',
        'mobile_phone',
        'facebook_id',
        'google_id',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

     public function jobs(){

        return $this->hasMany(PostJob::class);
    }

    public function business_events(){

        return $this->belongsTo(BusinessEvent::class);

    }


    public function businessListings(){

        return $this->hasMany(BusinessListing::class);

    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

     public function loginHistories()
    {
        return $this->hasMany(LoginHistory::class);
    }

    public function redirectToDashboard()
    {
        if(!$this->hasRole('business_owner')){

             return route('dashboard');  
        }
            
        $hasListing = BusinessListing::where('user_id', $this->id)->exists();

        return $hasListing ? route('business_owner.dashboard') : route('business-listings.add');
    }

}
