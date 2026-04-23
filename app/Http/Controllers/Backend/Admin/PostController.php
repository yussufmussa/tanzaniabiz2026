<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post\Post;
use App\Models\Post\PostCategory;
use App\Models\Post\PostTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $query = Post::with(['postCategory', 'user'])
            ->orderBy('created_at', 'desc');

        if (auth()->user()->hasRole(['writer'])) {
            $query->where('user_id',  auth()->id());
        }

        $posts = $query->paginate();

        return view('backend.blog.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $categories = PostCategory::orderBy('name', 'asc')->get();
        $tags = PostTag::orderBy('name', 'asc')->get();

        return view('backend.blog.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {

        $request->validated();

        $thumbanailDir = 'uploads/posts/thumbnails/';
        if (!is_dir(public_path($thumbanailDir))) {
            mkdir(public_path($thumbanailDir), 0755, true);
        }

        $manager = new ImageManager(new GdDriver());
        $originalImage = $manager->read($request->file('thumbnail')->getRealPath());

        $desktopFileName = Str::uuid() . '.webp';
        $desktopPath = public_path('uploads/posts/thumbnails/' . $desktopFileName);
        $desktopImage = clone $originalImage;
        $desktopImage->cover(640, 427) 
            ->toWebp(80)
            ->save($desktopPath);

        $thumbnailName = $desktopFileName;

        $isPublished = $request->is_published;

        if (auth()->user()->hasRole(['writer'])) {
            $isPublished = 0;
        }

        $post = Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
            'is_published' => $isPublished,
            'thumbnail' => $thumbnailName,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'category_id' => $request->category_id,
            'user_id' => auth()->id(),
        ]);

        // Attach tags
        if ($request->has('tags')) {
            $post->postTags()->sync($request->tags);
        }

        return redirect()->route('posts.index')->with('message', 'Blog post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function edit(Post $post)
    {

        $categories = PostCategory::all();
        $tags = PostTag::all();
        $selectedTags = $post->postTags->pluck('id')->toArray();

        return view('backend.blog.posts.edit', compact('post', 'categories', 'tags', 'selectedTags'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
       
        $request->validated();

        $isPublished = $request->is_published;

        if (auth()->user()->hasRole(['writer'])) {
            $isPublished = 0;
        }

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
            'is_published' => $isPublished,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'category_id' => $request->category_id,
        ];

        if ($request->hasFile('thumbnail')) {

            if ($post->thumbnail) {
                $oldThumbnailPath = public_path('uploads/posts/thumbnails/' . $post->thumbnail);
                if (file_exists($oldThumbnailPath)) {
                    unlink($oldThumbnailPath);
                }
            }

            $manager = new ImageManager(new GdDriver());
            $originalImage = $manager->read($request->file('thumbnail')->getRealPath());

            $desktopFileName = Str::uuid() . '.webp';
            $desktopPath = public_path('uploads/posts/thumbnails/' . $desktopFileName);
            $desktopImage = clone $originalImage;
             $desktopImage->cover(640, 427)  
                ->toWebp(80) 
                ->save($desktopPath);

            $data['thumbnail'] = $desktopFileName;
        }

        $post->update($data);

        if ($request->has('tags')) {
            $post->postTags()->sync($request->tags);
        } else {
            $post->postTags()->detach();
        }

        return redirect()->route('posts.index')->with('message', 'Blog post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::where('id', $id)->firstOrFail();

        if (auth()->user()->hasRole('writer') && $post->user_id !== auth()->id()) {
            abort(403, 'You can only delete your own posts.');
        }

        $postPath = public_path() . '/uploads/posts/thumbnails/' . $post->thumbnail;
        if (File::exists($postPath)) {
            File::delete($postPath);
        }

        if ($post->delete()) {
            return back()->with('message', 'Post deleted successfully');
        } else {
            return back()->with('error', 'Failed to delete Post');
        }
    }



    public function toggleStatus(Post $post)
    {

        $post->update(['is_published' => !$post->is_published]);

        $status = $post->is_published ? 'marked as published' : 'marked as draft';
        return response()->json([
            'success' => true,
            'message' => "Post {$status} successfully!",
            'is_published' => $post->is_published
        ]);
    }

    public function bulkDelete(Request $request)
    {

        $request->validate([
            'selected_posts' => 'required|array',
            'selected_posts.*' => 'exists:posts,id'
        ]);

        $postIds = $request->selected_posts;
        $posts = Post::whereIn('id', $postIds)->get();

        $deletedCount = 0;

        foreach ($posts as $post) {
            $postPath = public_path() . '/uploads/posts/thumbnails/' . $post->thumbnail;
            if (File::exists($postPath)) {
                File::delete($postPath);
            }

            // Delete the database record
            if ($post->delete()) {
                $deletedCount++;
            }
        }

        if ($deletedCount > 0) {
            return back()->with('message', $deletedCount . ' Posts deleted successfully');
        } else {
            return back()->with('error', 'Failed to delete Posts');
        }
    }
}
