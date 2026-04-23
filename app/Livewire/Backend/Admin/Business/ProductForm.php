<?php

namespace App\Livewire\Backend\Admin\Product;

use App\Models\Product\Brand as ProductBrand;
use App\Models\Product\Category as ProductCategory;
use App\Models\Product\Product as ProductProduct;
use App\Models\Product\SubCategory as ProductSubCategory;
use App\Models\Product\ProductPhoto;
use Exception;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Log;

class ProductForm extends Component
{
    use WithFileUploads;

    public $productId;
    public $isEditing = false;

    // Main fields
    public $title = '';
    public $category_id = '';
    public $sub_category_id = '';
    public $brand_id = '';
    public $price = '';
    public $description = '';
    public $meta_keywords = '';
    public $meta_description = '';
    public $thumbnail;
    public $currentThumbnail;

    // related array
    public $newPhotos = [];
    public $existingPhotos = [];
    public $photosToDelete = [];

    // Status flags
    public $is_active = false;
    public $is_popular = false;
    public $is_featured = false;

    // Timestamps
    public $created_at;
    public $updated_at;

    // Collections
    public $categories = [];
    public $subCategories = [];
    public $brands = [];

    /**
     * Mount the component
     */
    public function mount($productId = null)
    {
        $this->loadCategories();
        $this->loadBrands();

        if ($productId) {
            $this->isEditing = true;
            $this->productId = $productId;
            $this->loadProduct($productId);
        }
    }

    /**
     * Load product data for editing
     */
    protected function loadProduct($productId)
    {
        $product = ProductProduct::with(['productPhotos'])->findOrFail($productId);

        $this->title = $product->title;
        $this->category_id = $product->category_id;
        $this->sub_category_id = $product->sub_category_id;
        $this->brand_id = $product->brand_id;
        $this->price = $product->price;
        $this->description = $product->description;
        $this->meta_keywords = $product->meta_keywords;
        $this->meta_description = $product->meta_description;
        $this->is_active =  (bool)  $product->is_active;
        $this->is_popular =  (bool)  $product->is_popular;
        $this->is_featured =  (bool)  $product->is_featured;
        $this->currentThumbnail = $product->thumbnail;
        $this->existingPhotos = $product->productPhotos;
        $this->created_at = $product->created_at;
        $this->updated_at = $product->updated_at;

        $this->loadSubCategories();
    }

    /**
     * Load categories
     */
    protected function loadCategories()
    {
        $this->categories = ProductCategory::active()
            ->orderBy('name')
            ->get();
    }

    /**
     * Load brands
     */
    protected function loadBrands()
    {
        $this->brands = ProductBrand::active()
            ->orderBy('name')
            ->get();
    }

    /**
     * Load sub-categories based on selected category
     */
    protected function loadSubCategories()
    {
        if ($this->category_id) {
            $this->subCategories = ProductSubCategory::where('category_id', $this->category_id)
                ->active()
                ->orderBy('name')
                ->get();
        } else {
            $this->subCategories = [];
            $this->sub_category_id = '';
        }
    }

    /**
     * Watch category_id changes and load sub-categories
     */
    public function updatedCategoryId()
    {
        $this->sub_category_id = '';
        $this->loadSubCategories();
    }


    /**
     * Remove existing photo
     */
    public function removeExistingPhoto($photoId)
    {
        $photo = ProductPhoto::findOrFail($photoId);
        $this->photosToDelete[] = $photoId;

        $this->existingPhotos = $this->existingPhotos->filter(function ($item) use ($photoId) {
            return $item->id !== $photoId;
        });
    }

    /**
     * Remove new photo from upload queue
     */
    public function removeNewPhoto($index)
    {
        array_splice($this->newPhotos, $index, 1);
    }

    /**
     * Validation rules (for custom validation)
     */
    protected function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'brand_id' => 'required|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:500',
            'meta_description' => 'nullable|string|max:160',
            'newPhotos' => 'nullable|array|max:10',
            'newPhotos.*' => 'image|max:5120',
        ];

        if (!$this->isEditing) {
            $rules['thumbnail'] = 'required|mimes:jpg,png,webp,svg|max:2048';
        } else {
            $rules['thumbnail'] = 'nullable|mimes:jpg,png,webp,svg|max:2048';
        }

        return $rules;
    }

    /**
     * Custom validation messages
     */
    protected function messages()
    {
        return [
            'title.required' => 'Product title is required.',
            'category_id.required' => 'Please select a category.',
            'sub_category_id.required' => 'Please select a sub-category.',
            'brand_id.required' => 'Please select a brand.',
            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a number.',
            'price.min' => 'Price cannot be negative.',
            'thumbnail.required' => 'Product thumbnail is required.',
            'thumbnail.max' => 'Thumbnail size must not exceed 2MB.',
            'newPhotos.max' => 'You can upload maximum 10 photos at once.',
            'newPhotos.*.max' => 'Each gallery photo must not exceed 5MB.',
        ];
    }


    public function save()
    {

        // return dd($this->all());
        $this->validate();

        try {

            if ($this->isEditing) {

                $this->updateProduct();

            } else {

               $this->createProduct();

            }


        return redirect()->route('admin.products.index')->with(['message' =>  $this->isEditing ? 'Product updated successfully!' : 'Product created successfully!']);
        } catch (\Exception $e) {
            Log::error('Product save failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => [
                    'title' => $this->title,
                    'category_id' => $this->category_id,
                    'is_active' => $this->is_active,
                ]
            ]);
        }
    }

    /**
     * Create new product
     */
    protected function createProduct()
    {

        try {

            $thumbnailsDirectory = public_path('uploads/products/thumbnails');
            if (!file_exists($thumbnailsDirectory)) {
                mkdir($thumbnailsDirectory, 0755, true);
            }

            $filename = Str::uuid() . '.webp';
            $image = Image::read($this->thumbnail->getRealPath());


            // Mobile version - optimized for 312x274 display (with some buffer for retina)
            $mobileImage = $image->resize(624, 548, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $mobileWebpContent = $mobileImage->toWebp(75);
            $mobileTempPath = tempnam(sys_get_temp_dir(), 'webp_mobile_');
            file_put_contents($mobileTempPath, $mobileWebpContent);
            $mobileFilename = 'mobile_' . $filename;
            Storage::disk('public_real')->putFileAs('uploads/products/thumbnails', new File($mobileTempPath), $mobileFilename);
            unlink($mobileTempPath);

            // Desktop version - optimized for larger displays but still reasonable
            $desktopImage = $image->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $desktopWebpContent = $desktopImage->toWebp(80);
            $desktopTempPath = tempnam(sys_get_temp_dir(), 'webp_desktop_');
            file_put_contents($desktopTempPath, $desktopWebpContent);
            $desktopFilename = 'desktop_' . $filename;
            Storage::disk('public_real')->putFileAs('uploads/products/thumbnails', new File($desktopTempPath), $desktopFilename);
            unlink($desktopTempPath);


            // Create product
            $product = ProductProduct::create([
                'title' => $this->title,
                'slug' => Str::slug($this->title),
                'category_id' => $this->category_id,
                'sub_category_id' => $this->sub_category_id,
                'brand_id' => $this->brand_id,
                'price' => $this->price,
                'description' => $this->description,
                'meta_keywords' => $this->meta_keywords,
                'meta_description' => $this->meta_description,
                'thumbnail' => $desktopFilename,
                'thumbnail_mobile' => $mobileFilename,
                'is_active' => $this->is_active,
                'is_popular' => $this->is_popular,
                'is_featured' => $this->is_featured,
            ]);

            // Upload gallery photos
            if (!empty($this->newPhotos)) {
                $this->uploadGalleryPhotos($product->id);
            }

            $this->productId = $product->id;
        } catch (Exception $e) {
            Log::error('Create product failed', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e; // Re-throw to be caught by save() method
        }
    }

    /**
     * Update existing product
     */
    protected function updateProduct()
    {
        $product = ProductProduct::findOrFail($this->productId);

        $updatedData = [
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'category_id' => $this->category_id,
            'sub_category_id' => $this->sub_category_id,
            'brand_id' => $this->brand_id,
            'price' => $this->price,
            'description' => $this->description,
            'meta_keywords' => $this->meta_keywords,
            'meta_description' => $this->meta_description,
            'is_active' => $this->is_active,
            'is_popular' => $this->is_popular,
            'is_featured' => $this->is_featured,
        ];

        if ($this->isEditing && $this->thumbnail) {
            // Delete old mobile and desktop versions
            $oldMobilePath = public_path('uploads/products/thumbnails/' . $product->thumbnail_mobile);
            $oldDesktopPath = public_path('uploads/products/thumbnails/' . $product->thumbnail);

            if (file_exists($oldMobilePath)) {
                unlink($oldMobilePath);
            }
            if (file_exists($oldDesktopPath)) {
                unlink($oldDesktopPath);
            }

            $filename = Str::uuid() . '.webp';
            $image = Image::read($this->thumbnail->getRealPath());

            // Mobile version - optimized for 312x274 display (with some buffer for retina)
            $mobileImage = $image->resize(624, 548, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $mobileWebpContent = $mobileImage->toWebp(75); // Lower quality for mobile
            $mobileTempPath = tempnam(sys_get_temp_dir(), 'webp_mobile_');
            file_put_contents($mobileTempPath, $mobileWebpContent);
            $mobileFilename = 'mobile_' . $filename;
            Storage::disk('public_real')->putFileAs('uploads/products/thumbnails', new File($mobileTempPath), $mobileFilename);
            unlink($mobileTempPath);

            // Desktop version - optimized for larger displays but still reasonable
            $desktopImage = $image->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $desktopWebpContent = $desktopImage->toWebp(80);
            $desktopTempPath = tempnam(sys_get_temp_dir(), 'webp_desktop_');
            file_put_contents($desktopTempPath, $desktopWebpContent);
            $desktopFilename = 'desktop_' . $filename;
            Storage::disk('public_real')->putFileAs('uploads/products/thumbnails', new File($desktopTempPath), $desktopFilename);
            unlink($desktopTempPath);

            // Store the filenames in database
            $updatedData['thumbnail'] = $desktopFilename;
            $updatedData['thumbnail_mobile'] = $mobileFilename;
        }
        
        $product->update($updatedData);

        // Delete marked photos
        if (!empty($this->photosToDelete)) {
            foreach ($this->photosToDelete as $photoId) {
                $photo = ProductPhoto::find($photoId);
                if ($photo) {
                    if (Storage::disk('public_real')->exists('uploads/products/photos/' . $photo->photo_name)) {
                        Storage::disk('public_real')->delete('uploads/products/photos/' . $photo->photo_name);
                    }
                    $photo->delete();
                }
            }
        }

        // Upload new gallery photos
        if (!empty($this->newPhotos)) {
            $this->uploadGalleryPhotos($product->id);
        }
    }

    protected function uploadGalleryPhotos($productId)
    {
        foreach ($this->newPhotos as $photo) {
            if ($photo) {
                $filename = Str::uuid() . '.webp';

                // Process image with Intervention Image
                $image = Image::read($photo->getRealPath());
                $webpContent = $image->toWebp(80);

                // Create temporary file for storeAs method
                $tempPath = tempnam(sys_get_temp_dir(), 'webp_');
                file_put_contents($tempPath, $webpContent);

            Storage::disk('public_real')->putFileAs('uploads/products/photos', new File($tempPath), $filename);

                unlink($tempPath);

                ProductPhoto::create([
                    'product_id' => $productId,
                    'photo_name' => $filename,
                ]);
            }
        }
    }

    public function render()
    {
        return view('livewire.backend.admin.product.product-form');
    }
}
