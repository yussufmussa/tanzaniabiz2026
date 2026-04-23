<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post\Post;
use App\Models\Post\PostCategory;
use App\Models\Post\PostTag;
use App\Models\User;
use Illuminate\Http\Request;

class BlogPageController extends Controller
{
    public function postDetails($slug)
    {

        $post = Post::where('slug', $slug)
                            ->with(['user'])
                            ->published()
                            ->first();

        if (!$post) {
            abort(404);
        }

        $categories = PostCategory::where('is_active', true)
            ->withCount([
                'posts as posts_count' => function ($q) {
                    $q->where('is_published', 1);
                }
            ])
            ->having('posts_count', '>', 0)
            ->OrderByDesc('posts_count')
            ->limit(6)
            ->get();

        $relatedPosts = Post::where('slug', '!=', $slug)->published()->limit(5)->get();

        return view('frontend.pages.posts.details', compact('post', 'relatedPosts', 'categories'));
    }


    public function allPosts()
    {

        $posts = Post::published()
                        ->with(['user'])
                        ->latest()
                        ->get();

        return view('frontend.pages.posts.all', compact('posts'));
    }

    public function postsByCategory(string $slug)
    {
        $category = PostCategory::where('is_active', true)
                        ->where('slug', $slug)
                        ->firstOrFail();

        $posts = Post::published()->with(['user'])
                        ->where('category_id', $category->id)
                        ->latest()
                        ->get();

        return view('frontend.pages.posts.all', compact('posts', 'category'));
    }

    public function postsByUser(string $username)
    {
        $user = User::where('name', $username)->firstOrFail();

        $posts = Post::published()->with(['user'])
                        ->where('user_id', $user->id)
                        ->latest()
                        ->paginate(12);

        return view('frontend.pages.posts.all', compact('user', 'posts'));
    }

    public function postsByTag(string $slug)
    {
        $tag = PostTag::where('slug', $slug)->firstOrFail();

        $posts = Post::published()->with(['user'])
                        ->whereHas('postTags', fn($q) => $q->where('post_tags.id', $tag->id))
                        ->latest()
                        ->paginate(12);

        return view('frontend.pages.posts.all', compact('tag', 'posts'));
    }
}
