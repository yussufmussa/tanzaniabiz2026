<?php

namespace App\Models\Post;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'body',
        'is_published',
        'published_at',
        'meta_keywords',
        'meta_descripton',
        'thumbnail',
        'user_id',
        'category_id',
    ];

    public function postCategory()
    {

        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    public function user()
    {

        return $this->belongsTo(User::class);
    }

    public function postTags()
    {

        return $this->belongsToMany(PostTag::class, 'post_post_tags', 'post_id', 'post_tag_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
