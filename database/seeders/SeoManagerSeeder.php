<?php

namespace Database\Seeders;

use App\Models\SeoManager;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeoManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SeoManager::create([
            'meta_title' => 'Tanzania Business Directory & Jobs | Tanzaniabiz',
            'meta_description' => 'Find businesses, services, and jobs in Tanzania. Search by city or category. Add your business and reach more customers.',
            'meta_keywords' => 'tanzania business directory, companies in tanzania, tanzania jobs, list your business tanzania, local businesses tanzania',
            'google_analytics_code' => 'UA-XXXXXXXXX-X',
            'google_tag_manager' => 'GTM-XXXXXX',
            'facebook_pixel' => '', 
        ]);
    }
}
