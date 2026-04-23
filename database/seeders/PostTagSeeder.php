<?php

namespace Database\Seeders;

use App\Models\Post\PostTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
       $tags = [
            // Destinations
            'Zanzibar',
            'Stone Town',
            'Serengeti',
            'Ngorongoro Crater',
            'Kilimanjaro',
            'Pemba Island',
            'Mafia Island',
            'Prison Island',
            'Spice Farm',
            'Jozani Forest',
            
            // Activities
            'Safari',
            'Big Five',
            'Wildebeest Migration',
            'Cultural Heritage',
            'Swahili Culture',
            'Local Cuisine',
            'Seafood',
            'Sunset Cruise',
            'Dhow Sailing',
            'Coral Reefs',
            'Marine Life',
            'Dolphins',
            'Whale Watching',
            
            // Landmarks
            'Rock City',
            'Forodhani Gardens',
            'Mercury House',
            'Sultan Palace',
            'Arabic Architecture',
            'Indian Ocean',
            'Tropical Paradise',
            'White Sand Beaches',
            'Coconut Palms',
            
            // Local Culture
            'Traditional Fishing',
            'Local Markets',
            'Handicrafts',
            'Tingatinga Art',
            'Kanga Textiles',
            'Makonde Carvings',
            
            // Activities & Interests
            'Photography',
            'Birding',
            'Mangrove Tours',
            'Village Tours',
            'Responsible Tourism',
            'Eco-Tourism',
            
            // Travel Types
            'Luxury Travel',
            'Budget Travel',
            'Honeymoon',
            'Family Friendly',
            'Solo Travel',
            'Group Tours',
            'Private Tours',
            'Guided Tours',
            'Self Drive',
            
            // Accommodation
            'Camping',
            'Lodge Stay',
            'Beach Resort',
            'Boutique Hotel',
            'Guesthouse',
            
            // Food & Spices
            'Traditional Cuisine',
            'Street Food',
            'Tropical Fruits',
            'Spices',
            'Cloves',
            'Cardamom',
            'Cinnamon',
            'Vanilla',
            'Black Pepper'
        ];

        foreach ($tags as $tag) {
            PostTag::create([
                'name' => $tag,
                'slug' => Str::slug($tag),
            ]);
        }
    }
}
