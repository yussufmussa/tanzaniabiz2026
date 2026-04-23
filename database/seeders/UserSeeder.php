<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Yussuf Mussa',
            'email' => 'alphillipsa@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('root'),
            'is_active' => true,
            'profile_picture' => 'user.png',
            'mobile_phone' => '1234567890',
        ]);

        $admin->assignRole('admin');

        $manager = User::create([
            'name' => 'Yussuf Manger',
            'email' => 'manager@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('root'),
            'is_active' => true,
            'profile_picture' => 'user.png',
            'mobile_phone' => '1234567830',
        ]);

        $manager->assignRole('manager');

         $business_owner = User::create([
            'name' => 'Yussuf Mussa',
            'email' => 'phoneodin@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('root'),
            'is_active' => true,
            'profile_picture' => 'user.png',
            'mobile_phone' => '1234567830',
        ]);

        $business_owner->assignRole('business_owner');

         $writer = User::create([
            'name' => 'Yussuf Writer',
            'email' => 'zanarchipelago@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('root'),
            'is_active' => true,
            'profile_picture' => 'user.png',
            'mobile_phone' => '1234567830',
        ]);

        $writer->assignRole('writer');

         $editor = User::create([
            'name' => 'Yussuf Editor',
            'email' => 'yussufhamad600@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('root'),
            'is_active' => true,
            'profile_picture' => 'user.png',
            'mobile_phone' => '1234567830',
        ]);

        $editor->assignRole('editor');
    }
}
