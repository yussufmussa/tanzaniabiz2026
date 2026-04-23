<?php

namespace Database\Seeders;

use App\Models\Business\Feature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $features = [
            [
                'key' => 'has_social_media_links',
                'name' => 'Social Media Links',
                'description' => 'Add social media profile links to your business',
                'type' => 'boolean',
                'category' => 'features',
                'sort_order' => 1,
            ],
            [
                'key' => 'max_listings',
                'name' => 'Business Listings',
                'description' => 'Maximum number of business listings you can create',
                'type' => 'numeric',
                'category' => 'limits',
                'sort_order' => 2,
            ],
            [
                'key' => 'max_photos',
                'name' => 'Photos',
                'description' => 'Maximum number of photos per business listing',
                'type' => 'numeric',
                'category' => 'limits',
                'sort_order' => 3,
            ],
            [
                'key' => 'has_basic_info',
                'name' => 'Basic Business Info',
                'description' => 'Add business name, address, phone number, and email',
                'type' => 'boolean',
                'category' => 'features',
                'sort_order' => 4,
            ],
            [
                'key' => 'has_featured_section',
                'name' => 'Featured Section',
                'description' => 'Your business will be featured in the homepage section',
                'type' => 'boolean',
                'category' => 'features',
                'sort_order' => 5,
            ],
            [
                'key' => 'has_video',
                'name' => 'Video Feature',
                'description' => 'Add video to your business listing',
                'type' => 'boolean',
                'category' => 'features',
                'sort_order' => 6,
            ],
            [
                'key' => 'has_follow_link',
                'name' => 'Follow Link',
                'description' => 'Enable follow link for your business',
                'type' => 'boolean',
                'category' => 'features',
                'sort_order' => 7,
            ],
            [
                'key' => 'max_subcategories',
                'name' => 'Subcategories',
                'description' => 'Maximum number of subcategories per business',
                'type' => 'numeric',
                'category' => 'limits',
                'sort_order' => 8,
            ],
            [
                'key' => 'max_products',
                'name' => 'Products',
                'description' => 'Maximum number of products per business listing',
                'type' => 'numeric',
                'category' => 'limits',
                'sort_order' => 9,
            ],
            [
                'key' => 'max_jobs',
                'name' => 'Job Offers',
                'description' => 'Maximum number of job offers per business listing',
                'type' => 'numeric',
                'category' => 'limits',
                'sort_order' => 10,
            ],
        ];
        

        foreach ($features as $feature) {
            Feature::updateOrCreate(
                ['key' => $feature['key']],
                $feature
            );
        }
    }
}
