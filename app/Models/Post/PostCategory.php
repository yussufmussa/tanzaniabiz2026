<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    protected  $fillable  = [
        'name',
        'slug',
        'is_active',
    ];

    public function posts(){
        return $this->hasMany(Post::class, 'category_id');
    }
}
