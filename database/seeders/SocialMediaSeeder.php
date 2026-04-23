<?php

namespace Database\Seeders;

use App\Models\Business\SocialMedia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $socialmedias = [
            'facebook',
            'twitter',
            'instagram',
            'linkedin',
            'whatsapp',
        ];

        foreach ($socialmedias as $name) {
            SocialMedia::firstOrCreate(['name' => $name]);
        }
    }
}
