<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessListingStoreRequest;
use App\Http\Requests\BusinessListingUpdateRequest;
use App\Mail\BusinessListingApprovedMail;
use App\Models\Business\BusinessListing;
use App\Models\Business\Category;
use App\Models\Business\City;
use App\Models\Business\Photo;
use App\Models\Business\Product;
use App\Models\Business\SocialMedia;
use App\Models\Business\SubCategory;
use App\Services\BusinessListingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AdminListingController extends Controller
{
    public function __construct(private BusinessListingService $businessListingService) {}

    public function index()
    {

        return view('backend.business.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $cities = City::orderBy('city_name')->get();
        $subCategories = SubCategory::orderBy('name')->get();
        $socialMedias = SocialMedia::orderBy('name')->get();

        $days = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday'
        ];

        $workingHours = collect();

        return view('backend.business.create', compact(
            'categories',
            'cities',
            'subCategories',
            'socialMedias',
            'days',
            'workingHours'
        ));
    }

    public function store(BusinessListingStoreRequest $request)
    {
         $this->businessListingService->create($request->validated());
        
        return redirect()->route('listings.index')->with('success', 'Business listing created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BusinessListing $listing)
    {
        $listing->load(['photos', 'products', 'workingHours', 'subcategories', 'social_medias']);

        $categories    = Category::orderBy('name')->get();
        $subCategories = SubCategory::orderBy('name')->get();
        $cities        = City::orderBy('city_name')->get();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $socialMedias = SocialMedia::orderBy('name')->get();

        $workingHours = $listing->workingHours->keyBy('day_of_week');

        return view('backend.business.edit', compact('listing', 'categories', 'subCategories', 'cities', 'workingHours', 'days', 'socialMedias'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(BusinessListingUpdateRequest $request, BusinessListing $listing)
    {
        
          $this->businessListingService->update($request->validated(), $listing);

        return redirect()->route('listings.index')->with('success', 'Business listing updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BusinessListing $listing)
    {
        DB::transaction(function () use ($listing) {

            if ($listing->logo) {
                Storage::disk('public_real')->delete('uploads/businessListings/logos/' . $listing->logo);
            }

            foreach ($listing->photos as $photo) {
                if ($photo->name) {
                    Storage::disk('public_real')->delete('uploads/businessListings/photos/' . $photo->name);
                }
            }

            // Delete products photos files
            foreach ($listing->products as $product) {
                if ($product->photo) {
                    Storage::disk('public_real')->delete('uploads/businessListings/products/' . $product->photo);
                }
            }

            $listing->subcategories()->detach();
            $listing->social_medias()->detach();


            $listing->delete();
        });

        return redirect()->route('listings.index')->with('success', 'Business listing deleted.');
    }

}
