<?php

namespace Database\Seeders;

use App\Models\Post\PostCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $categories = [
           ['name' => 'Safari Adventures'],
              ['name' => 'Cultural Tours'],
              ['name' => 'Beach Holidays'],
              ['name' => 'Mountain Treks'],
              ['name' => 'Wildlife Safaris'],
              ['name' => 'Adventure Sports'],
              ['name' => 'Luxury Escapes'],
              ['name' => 'Family Vacations'],
              ['name' => 'Honeymoon Packages'],
              ['name' => 'Eco Tours'],
              ['name' => 'Historical Tours'],
        ];

        foreach ($categories as $category) {
            PostCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
            ]);

        }
    }
}
