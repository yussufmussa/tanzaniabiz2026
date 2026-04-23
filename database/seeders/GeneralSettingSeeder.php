<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        GeneralSetting::create([
            'name' => 'Tanzania Biz',
            'email' => 'info@tanzaniabiz.com',
            'mobile_phone' => '+255 689 532 954',
            'facebook' => '#',
            'instagram' => '#',
            'tiktok' => '#',
            'telegram' => '#',
            'google_business' => '#',
            'tripadvisor' => '#',
            'getyourguide' => '#',
            'twitter'  => '#',
            'youtube' => '#',
            'linkedin' => '#',
            'location' => 'Kariakoo - Dar es salaam',
    ]);
    }
}
