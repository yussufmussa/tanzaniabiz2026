<?php

namespace Database\Seeders;

use App\Models\Jobs\JobType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobtypes = [

        ['name' => 'Full time'],
        ['name' => 'Internship'],
        ['name' => 'Contract'],
        ['name' => 'Volunteer'],
        ['name' => 'Graduate Program'],

        ];

        foreach($jobtypes as $type){

            JobType::updateOrCreate([ 
                'name' => $type['name'],
                 'slug' => Str::slug($type['name'])
                 ]);

        }
    }
}
