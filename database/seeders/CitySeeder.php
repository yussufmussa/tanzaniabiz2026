<?php

namespace Database\Seeders;

use App\Models\Business\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $cities = [
            ['city_name' => 'Arusha'],
            ['city_name' => 'Dar es Salaam'],
            ['city_name' => 'Dodoma'],
            ['city_name' => 'Geita'],
            ['city_name' => 'Iringa'],
            ['city_name' => 'Kagera'],
            ['city_name' => 'Katavi'],
            ['city_name' => 'Kigoma'],
            ['city_name' => 'Kilimanjaro'],
            ['city_name' => 'Lindi'],
            ['city_name' => 'Manyara'],
            ['city_name' => 'Mara'],
            ['city_name' => 'Mbeya'],
            ['city_name' => 'Morogoro'],
            ['city_name' => 'Mtwara'],
            ['city_name' => 'Mwanza'],
            ['city_name' => 'Njombe'],
            ['city_name' => 'Pemba South'],
            ['city_name' => 'Pemba North'],
            ['city_name' => 'Pwani'],
            ['city_name' => 'Rukwa'],
            ['city_name' => 'Ruvuma'],
            ['city_name' => 'Shinyanga'],
            ['city_name' => 'Simiyu'],
            ['city_name' => 'Singida'],
            ['city_name' => 'Tabora'],
            ['city_name' => 'Tanga'],
            ['city_name' => 'Zanzibar Central/South'],
            ['city_name' => 'Zanzibar North'],
            ['city_name' => 'Zanzibar Urban/West'],
    ];

    foreach ($cities as $key => $value) {
       $city = new City();
       $city->city_name = $value['city_name'];
       $city->slug = Str::slug($value['city_name']);
       $city->save();
    }
}
}
