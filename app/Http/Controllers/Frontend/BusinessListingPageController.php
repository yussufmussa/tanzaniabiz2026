<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Business\BusinessListing;
use App\Models\Business\Category;
use App\Models\Business\City;
use App\Models\Business\SubCategory;
use Illuminate\Http\Request;

class BusinessListingPageController extends Controller
{
    public function businessDetail($slug)
    {
        $business = BusinessListing::with(['social_medias', 'category', 'user', 'photos', 'subcategories', 'workingHours', 'products'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        $relatedBusinesses = BusinessListing::with(['category', 'photos'])
            ->where('category_id', $business->category_id)
            ->where('id', '!=', $business->id)
            ->active()
            ->inRandomOrder()
            ->limit(6)
            ->get();

        return view('frontend.pages.listings.business_details', compact('business', 'relatedBusinesses'));
    }

    public function businessSearch(Request $request)
    {
        $keywords   = trim((string) $request->get('keywords'));
        $categoryId = $request->get('category_id');
        $cityId     = $request->get('city_id');

        return view('frontend.pages.listings.all_businesses', [
            'presetCategoryId' => $categoryId ?: null,
            'presetCityId'     => $cityId ?: null,
            'presetKeywords'   => $keywords ?: null,
            'presetCategorySlug' => null,
            'presetCitySlug' => null,
        ]);
    }

    public function Allbusinesses()
    {

        return view('frontend.pages.listings.all_businesses', [
            'presetCategorySlug' => null,
            'presetCitySlug' => null,
        ]);
    }

    public function browseByCategories()
    {

        $categories = Category::active()
            ->orderBy('name')
            ->with(['subcategories' => function ($q) {
                $q->active()
                    ->orderBy('name')
                    ->withCount('business_listings');
            }])
            ->get();

        $subcategoriesCount = SubCategory::active()->count();

        return view('frontend.pages.listings.categories', compact('categories', 'subcategoriesCount'));
    }

    public function byCategory($slug)
    {
        return view('frontend.pages.listings.all_businesses', [
            'presetCategorySlug' => $slug,
            'presetCitySlug' => null,
        ]);
    }

    public function byCity($slug)
    {
        return view('frontend.pages.listings.all_businesses', [
            'presetCategorySlug' => $slug,
            'presetCitySlug' => null,
        ]);
    }

    public function bySubCategory($slug)
    {
        return view('frontend.pages.listings.all_businesses', [
            'presetCategorySlug' => $slug,
            'presetCitySlug' => null,
        ]);
    }
}
