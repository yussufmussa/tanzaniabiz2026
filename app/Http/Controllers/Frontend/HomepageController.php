<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Business\BusinessListing;
use App\Models\Business\Category;
use App\Models\Business\City;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {

        $categories = Category::with('business_listings', 'subcategories')
                        ->limit(6)->get();

        $allCategories = Category::with('business_listings')->orderBy('name', 'asc')->get();

        $cities = City::orderBy('city_name', 'asc')->get();

        $listings =   BusinessListing::with('city', 'category', 'user')
                        ->where('status', 1)
                        ->latest()
                        ->take(8)
                        ->get();
        $totalListings = BusinessListing::where('status', 1)->count();

        $popularCategories = Category::active()
        ->withCount('business_listings')
        ->orderByDesc('business_listings_count')
        ->limit(5)
        ->get(['id','name','slug']);


        return view('frontend.index', compact('categories', 'allCategories', 'cities', 'listings', 'totalListings', 'popularCategories'));
    }
}
