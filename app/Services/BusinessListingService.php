<?php

namespace App\Services;

use App\Models\Business\BusinessListing;
use App\Models\Business\Photo;
use App\Models\Business\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class BusinessListingService
{
    private ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    public function create(array $data): BusinessListing
    {
        return DB::transaction(function () use ($data) {

            $newLogoName = time() . '_' . uniqid() . '.webp';

            $this->manager->read($data['logo'])->toWebp(75)->save(public_path('uploads/businessListings/logos/' . $newLogoName));

            $listing = BusinessListing::create([
                'name'               => $data['name'],
                'slug'               => Str::slug($data['name']),
                'description'        => $data['description'],
                'phone'              => $data['phone'],
                'website'            => $data['website'],
                'email'              => $data['email'],
                'location'           => $data['location'],
                'latitude'           => $data['latitude'] ?? null,
                'longitude'          => $data['longitude'] ?? null,
                'youtube_video_link' => $data['youtube_video_link'] ?? null,
                'status'             => $data['status'] ?? false,
                'is_featured'        => $data['is_featured'] ?? false,
                'category_id'        => $data['category_id'],
                'city_id'            => $data['city_id'],
                'logo'               => $newLogoName,
                'user_id'            => Auth::id(),
            ]);

            $listing->subcategories()->sync($data['sub_category_ids'] ?? []);

            $this->storeGalleryPhotos($listing, $data['photos'] ?? []);
            $this->storeProducts($listing, $data['products'] ?? []);
            $this->syncWorkingHours($listing, $data['working_hours'] ?? []);
            $this->syncSocialMedia($listing, $data['social_media'] ?? [], isCreate: true);

            return $listing;
        });
    }

    public function update(array $data, BusinessListing $listing): BusinessListing
    {
        return DB::transaction(function () use ($data, $listing) {

            $updateData = [
                'name'               => $data['name'],
                'slug'               => Str::slug($data['name']),
                'description'        => $data['description'],
                'phone'              => $data['phone'],
                'website'            => $data['website'],
                'email'              => $data['email'],
                'location'           => $data['location'],
                'latitude'           => $data['latitude'] ?? null,
                'longitude'          => $data['longitude'] ?? null,
                'youtube_video_link' => $data['youtube_video_link'] ?? null,
                'status'             => $data['status'] ?? false,
                'is_featured'        => $data['is_featured'] ?? false,
                'category_id'        => $data['category_id'],
                'city_id'            => $data['city_id'],
            ];

            // logo
            if (isset($data['logo'])) {
                if ($listing->logo) {
                    Storage::disk('public_real')->delete('uploads/businessListings/logos/' . $listing->logo);
                }
                $newLogoName = time() . '_' . uniqid() . '.webp';
                $this->manager->read($data['logo'])->toWebp(75)->save(public_path('uploads/businessListings/logos/' . $newLogoName));
                $updateData['logo'] = $newLogoName;
            }

            $listing->update($updateData);

            $listing->subcategories()->sync($data['sub_category_ids'] ?? []);

            // delete removed photos
            if (!empty($data['deleted_photos'])) {
                $photosToDelete = Photo::whereIn('id', $data['deleted_photos'])->where('business_listing_id', $listing->id)->get();

                foreach ($photosToDelete as $photo) {
                    Storage::disk('public_real')->delete('uploads/businessListings/photos/' . $photo->name);
                    $photo->delete();
                }
            }

            $this->storeGalleryPhotos($listing, $data['photos'] ?? []);

            // delete removed products
            if (!empty($data['deleted_products'])) {
                $productsToDelete = Product::whereIn('id', $data['deleted_products'])
                    ->where('business_listing_id', $listing->id)->get();

                foreach ($productsToDelete as $product) {
                    if ($product->photo) {
                        Storage::disk('public_real')->delete('uploads/businessListings/products/' . $product->photo);
                    }
                    $product->delete();
                }
            }

            // update existing products + create new ones
            if (!empty($data['products'])) {
                foreach ($data['products'] as $productData) {

                    $newFilename = null;

                    if (
                        isset($productData['photo']) &&
                        $productData['photo'] instanceof \Illuminate\Http\UploadedFile
                    ) {
                        $newFilename = time() . '_' . uniqid() . '.webp';

                        $this->manager->read($productData['photo'])
                            ->resize(550, 400)
                            ->toWebp(75)
                            ->save(public_path('uploads/businessListings/products/' . $newFilename));
                    }

                    if (isset($productData['id'])) {
                        $product = Product::where('id', $productData['id'])
                            ->where('business_listing_id', $listing->id)
                            ->first();

                        if ($product) {
                            $productUpdateData = [
                                'name'        => $productData['name'],
                                'description' => $productData['description'],
                                'price'       => $productData['price'] ?? null,
                            ];

                            if ($newFilename) {
                                if ($product->photo) {
                                    Storage::disk('public_real')->delete('uploads/businessListings/products/' . $product->photo);
                                }
                                $productUpdateData['photo'] = $newFilename;
                            }

                            $product->update($productUpdateData);
                        }
                    } else {
                        $listing->products()->create([
                            'name'        => $productData['name'],
                            'description' => $productData['description'],
                            'price'       => $productData['price'] ?? null,
                            'photo'       => $newFilename,
                        ]);
                    }
                }
            }

            $this->syncWorkingHours($listing, $data['working_hours'] ?? []);
            $this->syncSocialMedia($listing, $data['social_media'] ?? [], isCreate: false);

            return $listing;
        });
    }

    // -------------------------------------------------------------------------
    // Shared private helpers
    // -------------------------------------------------------------------------

    private function storeGalleryPhotos(BusinessListing $listing, array $photos): void
    {
        if (empty($photos)) {
            return;
        }

        $watermark = $this->manager->read(public_path('uploads/general/logo.png'));

        foreach ($photos as $photo) {
            $filename = time() . '_' . uniqid() . '.webp';

            $this->manager->read($photo)
                ->resize(1400, 900)
                ->place($watermark, 'center')
                ->toWebp(75)
                ->save(public_path('uploads/businessListings/photos/' . $filename));

            $listing->photos()->create(['name' => $filename]);
        }
    }

    private function storeProducts(BusinessListing $listing, array $products): void
    {
        foreach ($products as $productData) {

            $newFilename = null;

            if (
                isset($productData['photo']) &&
                $productData['photo'] instanceof \Illuminate\Http\UploadedFile
            ) {
                $newFilename = time() . '_' . uniqid() . '.webp';

                $this->manager->read($productData['photo'])
                    ->resize(550, 400)
                    ->toWebp(75)
                    ->save(public_path('uploads/businessListings/products/' . $newFilename));
            }

            $listing->products()->create([
                'name'        => $productData['name'],
                'description' => $productData['description'],
                'price'       => $productData['price'] ?? null,
                'photo'       => $newFilename,
            ]);
        }
    }

    private function syncWorkingHours(BusinessListing $listing, array $workingHours): void
    {
        foreach ($workingHours as $day => $hours) {
            $listing->workingHours()->updateOrCreate(
                ['day_of_week' => $day],
                [
                    'open_time'  => $hours['open_time'] ?? null,
                    'close_time' => $hours['close_time'] ?? null,
                    'is_24_7'   => (bool) ($hours['is_24_7'] ?? false),
                    'is_closed' => (bool) ($hours['is_closed'] ?? false),
                ]
            );
        }
    }

    private function syncSocialMedia(BusinessListing $listing, array $socialMedia, bool $isCreate): void
    {
        foreach ($socialMedia as $smData) {
            if (!empty($smData['link'])) {
                DB::table('business_listing_social_media')->updateOrInsert(
                    [
                        'business_listing_id' => $listing->id,
                        'social_media_id'     => $smData['social_media_id'],
                    ],
                    ['link' => $smData['link']]
                );
            } elseif (!$isCreate) {
                // on update, an empty link means the user removed it
                DB::table('business_listing_social_media')->where([
                    'business_listing_id' => $listing->id,
                    'social_media_id'     => $smData['social_media_id'],
                ])->delete();
            }
        }
    }
}
