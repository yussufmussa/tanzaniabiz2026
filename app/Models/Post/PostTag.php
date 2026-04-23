<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_post_tags', 'post_tag_id', 'post_id');
    }

    public function publishedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_post_tags', 'post_tag_id', 'post_post_id')
                    ->where('is_published', 1);
    }
}
