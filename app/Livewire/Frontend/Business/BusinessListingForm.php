<?php

namespace App\Livewire\Frontend\Business;

use App\Models\Business\BusinessListing;
use App\Models\Business\Category;
use App\Models\Business\City;
use App\Models\Business\Photo;
use App\Models\Business\Product;
use App\Models\Business\SocialMedia;
use App\Models\Business\SubCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BusinessListingForm extends Component
{

    use WithFileUploads;

    // Step Management
    public $currentStep = 1;
    public $listingId;
    public $mode = 'create';

    // Step 1: General Info
    public $name;
    public $category_id;
    public $subcategory_id = '';
    public $logo;
    public $existingLogo;
    public $description;
    public $city_id;
    public $location;
    public $email;
    public $phone;
    public $website;
    public $youtube_video_link;

    public $subcategories = [];
    public $categories = [];


    // Step 2: Photos
    public $photos = [];
    public $existingPhotos = [];
    public $photoIteration = 0;

    // Step 3: Products (max 3)
    public $products = [];
    public $maxProducts = 3;

    // Step 4: Extra Info
    public $social_media = [];
    public $working_hours = [];

    // Temporary logo preview
    public $logoPreview;

    // protected $listeners = ['subcategoriesLoaded'];

    public function mount($listingId = null)
    {
        $this->loadCategories();

        if ($listingId) {

            $this->mode = 'edit';
            $this->listingId = $listingId;
            $this->loadListing();
        } else {

            $this->initializeWorkingHours();
        }
    }

    public function initializeWorkingHours()
    {
        for ($i = 0; $i < 7; $i++) {
            $this->working_hours[$i] = [
                'day_of_week' => $i,
                'open_time' => '09:00',
                'close_time' => '17:00',
                'is_closed' => false,
                'is_24_7' => false,
            ];
        }
    }

    public function loadListing()
    {
        $listing = BusinessListing::with(['photos', 'products', 'subcategories', 'workingHours', 'social_medias'])
            ->findOrFail($this->listingId);

        $this->name = $listing->name;
        $this->category_id = $listing->category_id;
        $this->subcategory_id = $listing->subcategories->pluck('id')->toArray();
        $this->existingLogo = $listing->logo;
        $this->description = $listing->description;
        $this->city_id = $listing->city_id;
        $this->location = $listing->location;
        $this->phone = $listing->phone;
        $this->email = $listing->email;
        $this->website = $listing->website;
        $this->youtube_video_link = $listing->youtube_video_link;

        $this->existingPhotos = $listing->photos;

        $this->products = $listing->products->map(function ($product) {
            return [
                'id' => $product->id,
                'product_name' => $product->name,
                'price' => $product->price,
                'description' => $product->description,
                'existing_photo' => $product->photo,
                'photo' => null
            ];
        })->toArray();

        $this->loadSubCategories();

        foreach ($listing->social_medias as $social) {
            $this->social_media[$social->id] = $social->pivot->link;
        }

        foreach ($listing->workingHours as $workingHour) {
            $this->working_hours[$workingHour->day_of_week] = [
                'day_of_week' => $workingHour->day_of_week,
                'open_time'  => substr($workingHour->open_time, 0, 5),
                'close_time' => substr($workingHour->close_time, 0, 5),
                'is_closed'   => (bool) $workingHour->is_closed,
                'is_24_7'     => (bool) $workingHour->is_24_7,
            ];
        }

        for ($i = 0; $i < 7; $i++) {
            if (!isset($this->working_hours[$i])) {
                $this->working_hours[$i] = [
                    'day_of_week' => $i,
                    'open_time' => '09:00',
                    'close_time' => '17:00',
                    'is_closed' => false,
                    'is_24_7' => false,
                ];
            }
        }
    }


    public function rules()
    {

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                $this->mode === 'create'
                    ? Rule::unique('business_listings', 'name')
                    : Rule::unique('business_listings', 'name')->ignore($this->listingId),
            ],
            'logo'           => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],

            'category_id'    => ['required', 'exists:categories,id'],
            'subcategory_id' => ['required', 'exists:sub_categories,id'],
            'city_id'        => ['required', 'exists:cities,id'],

            'description' => ['required', 'string', 'max:60000'],
            'phone' => ['required', 'digits:10'],
            'website'        => ['url', 'max:255'],
            'location'       => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'max:255'],
            'youtube_video_link' => ['nullable', 'max:255'],
        ];
    }

    public function getValidationAttributes()
    {
        $attributes = [];

        foreach ($this->products as $index => $product) {
            $position = 'Product ' . ($index + 1);

            $attributes["products.$index.product_name"] = "$position name";
            $attributes["products.$index.description"]  = "$position description";
            $attributes["products.$index.price"]        = "$position price";
            $attributes["products.$index.photo"]        = "$position product photo";
        }

        // Photos tab (optional, but nice)
        foreach ($this->photos ?? [] as $i => $photo) {
            $attributes["photos.$i"] = 'Photo ' . ($i + 1);
        }


        return $attributes;
    }

    protected $messages = [
        'name.required' => 'Listing name is required.',
        'name.unique'   => 'Listing name already exists.',


        'logo.required' => 'Please upload a logo.',
        'logo.image'    => 'The logo must be an image file.',
        'logo.mimes'    => 'Logo must be a PNG, JPG, JPEG, or WEBP file.',
        'logo.max'      => 'Logo size must not exceed 2MB.',

        'category_id.required' => 'Please select a category.',
        'category_id.exists'   => 'Please select a valid category.',

        'subcategory_id.required' => 'Please select a subcategory.',
        'subcategory_id.exists'   => 'Please select a valid subcategory.',

        'city_id.required' => 'Please select a city.',
        'city_id.exists'   => 'Please select a valid city.',

        'description.required' => 'Please provide a description.',
        'phone.required'       => 'Phone number is required.',
        'phone.digits'       => 'Phone number must be 10 digits only.',
        'website.url'          => 'Please enter a valid website URL.',
        'location.required'    => 'Location is required.',

        // Products
        'products.*.product_name.required' => ':attribute is required.',
        'products.*.description.required'  => ':attribute is required.',
        'products.*.price.numeric'         => ':attribute must be a valid number.',
        'products.*.photo.image'           => ':attribute must be an image.',
        'products.*.photo.mimes'           => ':attribute must be a valid image file.',
        'products.*.photo.max'             => ':attribute must not exceed 2MB.',
    ];


    // ==================== STEP 1: GENERAL INFO ====================
    public function updatedLogo()
    {
        $this->validate(['logo' => 'mimes:png,jpg,jpeg,webp|max:2048']);
    }

    public function saveGeneral()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'category_id' => $this->category_id,
            'description' => $this->description,
            'city_id' => $this->city_id,
            'location' => $this->location,
            'email' => $this->email,
            'phone' => $this->phone,
            'website' => $this->website,
            'youtube_video_link' => $this->youtube_video_link,
            'user_id' => Auth::id(),
        ];

        if ($this->logo) {

            if ($this->mode == 'edit' && $this->existingLogo) {
                $oldPath = public_path('uploads/businessListings/logos/' . $this->existingLogo);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $manager = new ImageManager(new Driver());

            $filename = Str::uuid() . '.webp';
            $image = $manager->read($this->logo->getRealPath())->toWebp(75);
            $TempPath = tempnam(sys_get_temp_dir(), 'temp_');
            file_put_contents($TempPath, $image);

            Storage::disk('public_real')->putFileAs('uploads/businessListings/logos', new File($TempPath), $filename);
            unlink($TempPath);
            $data['logo'] = $filename;
        }

        if ($this->mode == 'create') {
            $listing = BusinessListing::create($data);
            $this->listingId = $listing->id;
            $this->mode = 'edit';
        } else {

            BusinessListing::where('id', $this->listingId)->update($data);
        }

        BusinessListing::find($this->listingId)->subcategories()->sync($this->subcategory_id);

        $this->dispatch('StatusUpdated', [
            'message' => 'General information saved successfully',
            'type' => 'success',
        ]);

        $this->nextStep();
    }

    // ==================== STEP 2: PHOTOS ====================
    public function updatedPhotos()
    {
        $totalCount = count($this->existingPhotos) + count($this->photos);

        if ($totalCount > 6) {
            $this->reset('photos');
            $this->photoIteration++;
            session()->flash('error', 'You can only upload a maximum of 6 photos total.');
            return;
        }

        $this->validate(['photos.*' => 'mimes:jpg,jpeg,png,webp|max:2048']);
    }

    public function removeNewPhoto($index)
    {
        array_splice($this->photos, $index, 1);
        $this->photoIteration++;
    }

    public function deleteExistingPhoto($photoId)
    {
        $photo = Photo::find($photoId);

        if ($photo && $photo->business_listing_id == $this->listingId) {

            $filePath = public_path('uploads/businessListings/photos/' . $photo->name);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $photo->delete();

            $listing = BusinessListing::with('photos')->find($this->listingId);
            $this->existingPhotos = $listing->photos;

            $this->dispatch('StatusUpdated', [
                'message' => 'Photo deleted successfully',
                'type' => 'success',
            ]);
        }
    }

    public function savePhotos()
    {

        $this->validate([
            'photos.*' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);


        foreach ($this->photos as $photo) {

            $manager = new ImageManager(new Driver());

            $filename = Str::uuid() . '.webp';
            $image = $manager->read($photo->getRealPath());

            $watermark = $manager->read(public_path('uploads/general/logo.png'));
            $waterMarkedPhoto = $image->place($watermark, 'center')->toWebp(80);

            $tempPath = tempnam(sys_get_temp_dir(), 'webp_');
            file_put_contents($tempPath, $waterMarkedPhoto);

            Storage::disk('public_real')->putFileAs('uploads/businessListings/photos', new File($tempPath), $filename);
            unlink($tempPath);

            Photo::create([
                'business_listing_id' => $this->listingId,
                'name' => $filename,
            ]);
        }

        $this->reset('photos');
        $this->photoIteration++;
        $this->loadListing();

        $this->dispatch('StatusUpdated', [
            'message' => 'Business photos saved successfully',
            'type' => 'success',
        ]);

        $this->nextStep();
    }

    public function skipPhotos()
    {
        $this->nextStep();
    }

    // ==================== STEP 3: PRODUCTS ====================
    public function addProduct()
    {
        if (count($this->products) < $this->maxProducts) {
            $this->products[] = [
                'product_name' => '',
                'price' => '',
                'description' => '',
                'photo' => null
            ];
        }
    }

    public function removeProduct($index)
    {
        // If it has an ID, delete from database
        if (isset($this->products[$index]['id'])) {

            $product = Product::find($this->products[$index]['id']);

            if ($product && $product->business_listing_id == $this->listingId) {

                $photoPath = public_path('uploads/businessListings/products/' . $product->photo);

                if (file_exists($photoPath) && is_file($photoPath)) {
                    unlink($photoPath);
                }

                $product->delete();
            }
        }

        array_splice($this->products, $index, 1);

        // Ensure at least one product field
        if (empty($this->products)) {
            $this->products = [
                ['product_name' => '', 'price' => '', 'description' => '', 'photo' => null]
            ];
        }

        $this->dispatch('StatusUpdated', [
            'message' => 'Products deleted successfully',
            'type' => 'success',
        ]);
    }

    public function saveProducts()
    {

        $this->validate([
            'products' => 'array',
            'products.*.product_name' => 'required|string|max:255',
            'products.*.description'  => 'required|string|max:255',
            'products.*.price'        => 'nullable|numeric',
            'products.*.photo'        => 'nullable|mimes:jpg,png,webp,jpeg,svg|max:2048',
        ]);

        foreach ($this->products as $product) {

            $productData = [
                'business_listing_id' => $this->listingId,
                'name' => $product['product_name'],
                'price' => $product['price'],
                'description' => $product['description'],
            ];

            if (isset($product['photo']) && $product['photo']) {

                $manager = new ImageManager(new Driver());

                $filename = Str::uuid() . '.webp';
                $image = $manager->read($product['photo']->getRealPath())->toWebp(75);
                $TempPath = tempnam(sys_get_temp_dir(), 'temp_');
                file_put_contents($TempPath, $image);

                Storage::disk('public_real')->putFileAs('uploads/businessListings/products', new File($TempPath), $filename);
                unlink($TempPath);

                $productData['photo'] = $filename;
            }

            if (isset($product['id'])) {
                Product::where('id', $product['id'])->update($productData);
            } else {
                Product::create($productData);
            }
        }

        $this->dispatch('StatusUpdated', [
            'message' => 'Products saved successfully',
            'type' => 'success',
        ]);

        $this->nextStep();
    }

    public function skipProducts()
    {
        $this->nextStep();
    }

    // ==================== STEP 4: EXTRA INFO ====================
    public function toggleDayClosed($dayIndex)
    {
        if ($this->working_hours[$dayIndex]['is_closed']) {
            $this->working_hours[$dayIndex]['is_24_7'] = false;
        }
    }

    public function toggleDay247($dayIndex)
    {
        if ($this->working_hours[$dayIndex]['is_24_7']) {
            $this->working_hours[$dayIndex]['is_closed'] = false;
        }
    }

    public function saveExtra()
    {
        $listing = BusinessListing::findOrFail($this->listingId);

        // SOCIAL MEDIA: update only filled inputs, keep others as-is
        foreach ($this->social_media as $platformId => $link) {
            if ($link === null) continue;

            $link = trim($link);

            // If empty string: interpret as "remove this one"
            if ($link === '') {
                $listing->social_medias()->detach($platformId);
                continue;
            }

            // Update or attach this platform link
            $listing->social_medias()->syncWithoutDetaching([
                $platformId => ['link' => $link],
            ]);
        }

        // WORKING HOURS: update each day (no duplicates)
        foreach ($this->working_hours as $dayIndex => $hours) {
            $listing->workingHours()->updateOrCreate(
                ['day_of_week' => $dayIndex],
                [
                    'open_time'  => (!($hours['is_closed'] ?? false) && !($hours['is_24_7'] ?? false)) ? ($hours['open_time'] ?? null) : null,
                    'close_time' => (!($hours['is_closed'] ?? false) && !($hours['is_24_7'] ?? false)) ? ($hours['close_time'] ?? null) : null,
                    'is_closed'  => (bool)($hours['is_closed'] ?? false),
                    'is_24_7'    => (bool)($hours['is_24_7'] ?? false),
                ]
            );
        }

        return redirect()->route('business-listings.index')->with(['success' => 'Business Listing completed']);
    }


    // ==================== NAVIGATION ====================
    public function nextStep()
    {
        $this->currentStep++;
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

    public function goToStep($step)
    {
        if ($step > 1 && !$this->listingId) {

            $this->dispatch('StatusUpdated', [
                'message' => 'Save general information first',
                'type' => 'error',
            ]);

            return;
        }

        $this->currentStep = $step;
    }

    public function updatedCategoryId()
    {
        $this->subcategory_id = '';
        $this->loadSubCategories();
    }

    protected function loadCategories()
    {
        $this->categories = Category::active()
            ->orderBy('name')
            ->get();
    }

    protected function loadSubCategories()
    {
        if ($this->category_id) {
            $this->subcategories = SubCategory::where('category_id', $this->category_id)
                ->active()
                ->orderBy('name')
                ->get();
        } else {
            $this->subcategories = [];
            $this->subcategory_id = '';
        }
    }

    public function render()
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        return view('livewire.frontend.business.business-listing-form', [
            'cities' => City::all(),
            'socialMediaPlatforms' => SocialMedia::all(),
            'days' => $days,
        ]);
    }
}
