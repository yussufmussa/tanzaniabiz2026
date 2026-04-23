<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleAndPermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(GeneralSettingSeeder::class);
        $this->call(SeoManagerSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(FeatureSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(SocialMediaSeeder::class);
        $this->call(PackageSeeder::class);
        $this->call(JobTypeSeeder::class);
        $this->call(JobSectorSeeder::class);
        $this->call(PostCategorySeeder::class);
        $this->call(PostTagSeeder::class);










    }
}
