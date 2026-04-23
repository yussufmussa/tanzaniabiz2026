<?php

namespace App\Http\Controllers\Backend\Business;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGeneralRequest;
use App\Http\Requests\UpdateGeneralRequest;
use App\Models\Business\BusinessListing;
use App\Models\Business\Category;
use App\Models\Business\City;
use App\Models\Business\Photo;
use App\Models\Business\Product;
use App\Models\Business\SocialMedia;
use App\Models\Business\SubCategory;
use App\Models\Business\WorkingHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BusinessListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listings = BusinessListing::where('user_id', auth()->id())
            ->with(['category', 'city', 'photos', 'products', 'workingHours', 'social_medias'])
            ->latest()
            ->get();


        return view('frontend.business_owner.business.index', compact('listings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $categories = Category::active()->orderBy('name', 'asc')->get();
        // $cities =     City::active()->orderBy('city_name', 'asc')->get();
        // $socialmedias = SocialMedia::active()->orderBy('name', 'asc')->get();

        // $socialMediaPlatforms = SocialMedia::where('is_active', 1)
        //     ->orderBy('name')
        //     ->get();

        // $businessSocialMedia = [];

        // $days = [
        //     1 => 'Monday',
        //     2 => 'Tuesday',
        //     3 => 'Wednesday',
        //     4 => 'Thursday',
        //     5 => 'Friday',
        //     6 => 'Saturday',
        //     7 => 'Sunday',
        // ];

        // $workingHours = [];

        return view('frontend.business_owner.business.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeGeneral(StoreGeneralRequest $request)
    {

        $request->validated();

        $listing = new BusinessListing();
        $listing->name = $request->name;
        $listing->slug = Str::slug($request->name);

        $manager = new ImageManager(new Driver());
        $logoRename = Str::uuid();
        $logoWebp = $logoRename . '.webp';
        $image = $manager->read($request->logo);
        $image->toWebp(85)->save(public_path('uploads/businessListings/logos/' . $logoWebp));


        $listing->logo = $logoWebp;
        $listing->description = $request->description;
        $listing->phone = $request->phone;
        $listing->youtube_video_link = $request->youtube_video_link;
        $listing->website = $request->website;
        $listing->location = $request->location;
        $listing->category_id = $request->category_id;
        $listing->city_id = $request->city_id;
        $listing->user_id = auth()->user()->id;
        $listing->package_id = 1;

        $listing->save();

        $listing->subcategories()->attach($request->subcategory_id);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'business_listing_id' => $listing->id,
                'message' => 'General information saved successfully'
            ]);
        }
    }

    public function updateGeneral(UpdateGeneralRequest $request, BusinessListing $listing)
    {
        $request->validated();

        if ($request->hasFile('logo')) {
            // Handle logo upload
            $manager = new ImageManager(new Driver());

            $logoRename = Str::uuid();
            $logoWebp = $logoRename . '.webp';
            $image = $manager->read($request->logo);

            $image->toWebp(85)
                ->save(public_path('uploads/businessListings/logos/' . $logoWebp));

            $generalInputs = [
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'city_id' => $request->city_id,
                'category_id' => $request->category_id,
                'location' => $request->location,
                'phone' => $request->phone,
                'website' => $request->website,
                'logo' => $logoWebp,
                'youtube_video_link' => $request->youtube_video_link,
            ];
        } else {
            $generalInputs = [
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'city_id' => $request->city_id,
                'category_id' => $request->category_id,
                'location' => $request->location,
                'phone' => $request->phone,
                'website' => $request->website,
                'youtube_video_link' => $request->youtube_video_link,
            ];
        }

        $listing->update($generalInputs);
        $listing->subcategories()->sync($request->subcategory_id);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'business_listing_id' => $listing->id,
                'message' => 'General information updated successfully'
            ]);
        }
    }


    public function updatePhotos(Request $request, $id)
    {
        $listing = BusinessListing::where('user_id', auth()->user()->id)->findOrFail($id);

        $request->validate([
            'photos.*' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($request->has('deleted_photos')) {
            Photo::whereIn('id', $request->deleted_photos)
                ->where('business_listing_id', $id)
                ->delete();
        }

        if ($request->hasFile('photos')) {
            foreach ($request->photos as $photo) {

                $newName = Str::uuid();
                $newNameWebp = $newName . '.webp';

                $manager = new ImageManager(new Driver());

                $image = $manager->read($photo->getRealPath());
                $watermark = $manager->read(public_path('uploads/general/logo.png'));
                $image->place($watermark, 'center')
                    ->toWebp(85)
                    ->save(public_path('uploads/businessListings/photos/' . $newNameWebp));


                Photo::create([
                    'name' => $newNameWebp,
                    'business_listing_id' => $listing->id
                ]);
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Photos saved successfully'
            ]);
        }
    }


    public function updateProducts(Request $request, $id)
    {
        $listing = BusinessListing::where('user_id', auth()->user()->id)->findOrFail($id);

        $request->validate([
            'products' => 'required|array|max:3',
            'products.*.id' => 'nullable|exists:products,id',
            'products.*.product_name' => 'required|string|max:255',
            'products.*.price' => 'nullable|numeric|min:0',
            'products.*.description' => 'required|string|max:255',
            'products.*.photo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $submittedProductIds = [];

        foreach ($request->products as $productData) {
            $photoPath = null;

            // Handle photo upload
            if (isset($productData['photo']) && $productData['photo'] instanceof \Illuminate\Http\UploadedFile) {
                $newName = Str::uuid();
                $newNameWebp = $newName . '.webp';

                $manager = new ImageManager(new Driver());

                $image = $manager->read($productData['photo']->getRealPath());
                $watermark = $manager->read(public_path('uploads/general/logo.png'));
                $image->place($watermark, 'center')
                    ->toWebp(85)
                    ->save(public_path('uploads/businessListings/products/' . $newNameWebp));

                $photoPath = $newNameWebp;
            }

            $data = [
                'business_listing_id' => $listing->id,
                'name' => $productData['product_name'],
                'description' => $productData['description'] ?? null,
                'price' => $productData['price'] ?? null,
            ];

            // Only add photo if uploaded
            if ($photoPath) {
                $data['photo'] = $photoPath;
            }

            // Update existing or create new
            if (isset($productData['id']) && $productData['id']) {
                $product = Product::where('id', $productData['id'])
                    ->where('business_listing_id', $listing->id)
                    ->first();

                if ($product) {
                    // Delete old photo if new one uploaded
                    if ($photoPath && $product->photo) {
                        $oldPhotoPath = public_path('uploads/businessListings/products/' . $product->photo);
                        if (file_exists($oldPhotoPath)) {
                            unlink($oldPhotoPath);
                        }
                    }

                    $product->update($data);
                    $submittedProductIds[] = $product->id;
                }
            } else {
                $product = Product::create($data);
                $submittedProductIds[] = $product->id;
            }
        }

        // Delete products that were not submitted (removed by user)
        Product::where('business_listing_id', $listing->id)
            ->whereNotIn('id', $submittedProductIds)
            ->each(function ($product) {
                if ($product->photo) {
                    $photoPath = public_path('uploads/businessListings/products/' . $product->photo);
                    if (file_exists($photoPath)) {
                        unlink($photoPath);
                    }
                }
                $product->delete();
            });

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Products saved successfully',
                'product_count' => $listing->products()->count()
            ]);
        }
    }

    public function updateExtraInfo(Request $request, $id)
    {
        $listing = BusinessListing::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'social_media' => 'nullable|array',
            'social_media.*' => 'nullable|url',
            'working_hours' => 'nullable|array',
            'working_hours.*.day_of_week' => 'required|integer|between:1,7',
            'working_hours.*.open_time' => 'nullable|date_format:H:i',
            'working_hours.*.close_time' => 'nullable|date_format:H:i',
            'working_hours.*.is_24_7' => 'nullable',
            'working_hours.*.is_closed' => 'nullable',
        ]);

        try {
            DB::beginTransaction();

            // Handle Social Media
            if ($request->has('social_media') && is_array($request->social_media)) {
                $socialMediaData = [];

                foreach ($request->social_media as $socialMediaId => $link) {
                    $link = trim($link);
                    if (!empty($link)) {
                        $socialMediaData[$socialMediaId] = ['link' => $link];
                    }
                }

                $listing->social_medias()->sync($socialMediaData);
            } else {
                $listing->social_medias()->detach();
            }

            // Handle Working Hours - only if submitted
            if ($request->has('working_hours') && is_array($request->working_hours)) {
                for ($day = 1; $day <= 7; $day++) {
                    $dayData = $request->working_hours[$day] ?? null;

                    if ($dayData) {
                        $isClosed = isset($dayData['is_closed']) && $dayData['is_closed'] == '1';
                        $is247 = isset($dayData['is_24_7']) && $dayData['is_24_7'] == '1';

                        $workingHoursData = [
                            'business_listing_id' => $listing->id,
                            'day_of_week' => $day,
                            'is_closed' => $isClosed,
                            'is_24_7' => $is247,
                            'open_time' => ($isClosed || $is247) ? null : ($dayData['open_time'] ?? null),
                            'close_time' => ($isClosed || $is247) ? null : ($dayData['close_time'] ?? null),
                        ];

                        WorkingHour::updateOrCreate(
                            [
                                'business_listing_id' => $listing->id,
                                'day_of_week' => $day
                            ],
                            $workingHoursData
                        );
                    }
                }
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Business Listing completed and submitted for approval!',
                    'redirect' => route('business-listings.index')
                ]);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to save extra info: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Failed to save extra info');
        }
    }


    public function edit($id)
    {
        $listing = BusinessListing::findOrFail($id);
        
        return view('frontend.business_owner.business.edit', compact('listing'));
    }


    public function destroy(string $id)
    {
        $listing = BusinessListing::where('user_id', auth()->id())->findOrFail($id);

        try {
            DB::beginTransaction();

            if ($listing->logo) {
                $logoPath = public_path('uploads/businessListings/logos/' . $listing->logo);
                if (file_exists($logoPath)) {
                    unlink($logoPath);
                }
            }

            foreach ($listing->photos as $photo) {
                $photoPath = public_path('uploads/businessListings/photos/' . $photo->name);
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                }
            }

            foreach ($listing->products as $product) {
                if ($product->photo) {
                    $productPhotoPath = public_path('uploads/businessListings/products/' . $product->photo);
                    if (file_exists($productPhotoPath)) {
                        unlink($productPhotoPath);
                    }
                }
            }

            $listing->delete();

            DB::commit();

            return redirect()->route('business-listings.index')->with('success', 'Listing deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('business-listings.index')->with('error', 'Failed to delete listing: ' . $e->getMessage());
        }
    }

    public function deletePhoto($photoId)
{
    try {
        $photo = Photo::findOrFail($photoId);
        
        // Delete file from storage
        $filePath = public_path('uploads/businessListings/photos/' . $photo->name);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        
        // Delete from database
        $photo->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Photo deleted successfully'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to delete photo: ' . $e->getMessage()
        ], 500);
    }
}
}
