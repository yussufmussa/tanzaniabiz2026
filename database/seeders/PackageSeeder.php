<?php

namespace Database\Seeders;

use App\Models\Business\Feature;
use App\Models\Business\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            'has_social_media_links' => Feature::where('key', 'has_social_media_links')->first(),
            'max_listings' => Feature::where('key', 'max_listings')->first(),
            'max_photos' => Feature::where('key', 'max_photos')->first(),
            'max_subcategories' => Feature::where('key', 'max_subcategories')->first(),
            'max_products' => Feature::where('key', 'max_products')->first(),
            'max_jobs' => Feature::where('key', 'max_jobs')->first(),
            'has_basic_info' => Feature::where('key', 'has_basic_info')->first(),
            'has_featured_section' => Feature::where('key', 'has_featured_section')->first(),
            'has_video' => Feature::where('key', 'has_video')->first(),
            'has_follow_link' => Feature::where('key', 'has_follow_link')->first(),

        ];

        // Basic Package
        $basic = Package::updateOrCreate(
            ['slug' => 'basic'],
            [
                'name' => 'Basic',
                'description' => 'Perfect for getting started with your first business listing',
                'price' => 9.99,
                'billing_period' => 'monthly',
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        // Delete existing features and add new ones
        $basic->packageFeatures()->delete();
        $basic->packageFeatures()->createMany([
            ['feature_id' => $features['has_social_media_links']->id, 'value' => 'true'],
            ['feature_id' => $features['max_listings']->id, 'value' => '1'],
            ['feature_id' => $features['max_photos']->id, 'value' => '3'],
            ['feature_id' => $features['max_products']->id, 'value' => '3'],
            ['feature_id' => $features['max_jobs']->id, 'value' => '3'],
            ['feature_id' => $features['has_featured_section']->id, 'value' => 'true'],
            ['feature_id' => $features['has_video']->id, 'value' => 'true'],
            ['feature_id' => $features['has_follow_link']->id, 'value' => 'true'],
            ['feature_id' => $features['has_basic_info']->id, 'value' => 'true'],
            ['feature_id' => $features['max_subcategories']->id, 'value' => '1'],
        ]);

        // Popular Package
        $popular = Package::updateOrCreate(
            ['slug' => 'popular'],
            [
                'name' => 'Popular',
                'description' => 'Most popular choice for growing businesses',
                'price' => 29.99,
                'billing_period' => 'monthly',
                'is_active' => true,
                'sort_order' => 2,
            ]
        );

        $popular->packageFeatures()->delete();
        $popular->packageFeatures()->createMany([
            ['feature_id' => $features['has_social_media_links']->id, 'value' => 'true'],
            ['feature_id' => $features['max_listings']->id, 'value' => '1'],
            ['feature_id' => $features['max_photos']->id, 'value' => '3'],
            ['feature_id' => $features['max_products']->id, 'value' => '3'],
            ['feature_id' => $features['max_jobs']->id, 'value' => '3'],
            ['feature_id' => $features['has_featured_section']->id, 'value' => 'true'],
            ['feature_id' => $features['has_video']->id, 'value' => 'true'],
            ['feature_id' => $features['has_follow_link']->id, 'value' => 'true'],
            ['feature_id' => $features['has_basic_info']->id, 'value' => 'true'],
            ['feature_id' => $features['max_subcategories']->id, 'value' => '1'],
        ]);

        // Premium Package (bonus)
        $premium = Package::updateOrCreate(
            ['slug' => 'premium'],
            [
                'name' => 'Premium',
                'description' => 'Full access with unlimited features for serious businesses',
                'price' => 79.99,
                'billing_period' => 'monthly',
                'is_active' => true,
                'sort_order' => 3,
            ]
        );

        $premium->packageFeatures()->delete();
        $premium->packageFeatures()->createMany([
            ['feature_id' => $features['has_social_media_links']->id, 'value' => 'true'],
            ['feature_id' => $features['max_listings']->id, 'value' => '1'],
            ['feature_id' => $features['max_photos']->id, 'value' => '3'],
            ['feature_id' => $features['max_products']->id, 'value' => '3'],
            ['feature_id' => $features['max_jobs']->id, 'value' => '3'],
            ['feature_id' => $features['has_featured_section']->id, 'value' => 'true'],
            ['feature_id' => $features['has_video']->id, 'value' => 'true'],
            ['feature_id' => $features['has_follow_link']->id, 'value' => 'true'],
            ['feature_id' => $features['has_basic_info']->id, 'value' => 'true'],
            ['feature_id' => $features['max_subcategories']->id, 'value' => '1'],
        ]);

    }
}
