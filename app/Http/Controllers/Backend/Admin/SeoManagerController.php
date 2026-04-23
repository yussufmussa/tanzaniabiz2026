<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoManager;
use Illuminate\Http\Request;

class SeoManagerController extends Controller
{
     public function index(){


        $seo = SeoManager::first();

        return view('backend.general_pages.seo', compact('seo'));
    }

    public function store(Request $request)
    {
        

        $seo = SeoManager::findOrFail($request->id);

        $updatedData = [
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'google_analytics_code' => $request->google_analytics_code,
            'facebook_pixel' => $request->facebook_pixel,
            'google_tag_manager' => $request->google_tag_manager,
            'google_adsense_code' => $request->google_adsense_code,
        ];

        $seo->update($updatedData);
    
        return back()->with(['message' => 'SEO setting update succefully']);
    }
}
