<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SocialMediaController extends Controller
{
   public function index()
    {
        $socialmedias = SocialMedia::orderBy('name', 'asc')->paginate();

        return view('backend.business.socialmedias.index', compact('socialmedias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('backend.business.socialmedias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|max:255|unique:social_media,name',
        ]);

       SocialMedia::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('socialmedias.index')->with(['message' => 'Social media created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SocialMedia $socialmedia)
    {
        return view('backend.business.socialmedias.edit', compact('socialmedia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SocialMedia $socialmedia)
    {

        $request->validate([
            'name' => 'required|max:255|unique:social_media,name,' . $socialmedia->id,
        ]);



        $socialmedia->update([

            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('socialmedias.index')->with(['message' => 'Social Updated Successfully']);
    }


    public function destroy(SocialMedia $socialmedia)
    {

        $socialmedia->delete();

        return redirect()->route('socialmedias.index')->with(['message' => 'SocialMedia deleted succefully']);
    }

}
