<?php

namespace Database\Seeders;

use App\Models\Jobs\JobSector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobSectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobsectors = [
            ['name' => 'Academic'],
            ['name' => 'Accounting'],
            ['name' => 'Admin'],
            ['name' => 'Administration'],
            ['name' => 'Advertising'],
            ['name' => 'Aerospace'],
            ['name' => 'Agriculture'],
            ['name' => 'Animal'],
            ['name' => 'Architect'],
            ['name' => 'Automotive'],
            ['name' => 'Banking'],
            ['name' => 'Basic Labor'],
            ['name' => 'Beauty'],
            ['name' => 'Business'],
            ['name' => 'Call Centre'],
            ['name' => 'Carpenter'],
            ['name' => 'Cashier'],
            ['name' => 'Catering'],
            ['name' => 'Charity'],
            ['name' => 'Chemistry'],
            ['name' => 'Cleaning'],
            ['name' => 'Construction'],
            ['name' => 'Consulting'],
            ['name' => 'Cruise Ship'],
            ['name' => 'Customer Service'],
            ['name' => 'Designer'],
            ['name' => 'Developer'],
            ['name' => 'Doctor'],
            ['name' => 'Driver'],
            ['name' => 'E-Commerce'],
            ['name' => 'Editorial'],
            ['name' => 'Education'],
            ['name' => 'Electrician'],
            ['name' => 'Engineering'],
            ['name' => 'Entertainment'],
            ['name' => 'Environmental'],
            ['name' => 'Executive'],
            ['name' => 'Fashion'],
            ['name' => 'Finance'],
            ['name' => 'Fitness'],
            ['name' => 'Food Service'],
            ['name' => 'General Worker'],
            ['name' => 'Government'],
            ['name' => 'Graduate'],
            ['name' => 'Graphic Design'],
            ['name' => 'Hairdresser'],
            ['name' => 'Healthcare'],
            ['name' => 'Hospitality'],
            ['name' => 'Hotel'],
            ['name' => 'Housekeeping'],
            ['name' => 'Human Resources'],
            ['name' => 'Import & Export'],
            ['name' => 'Insurance'],
            ['name' => 'International'],
            ['name' => 'Investment'],
            ['name' => 'IT'],
            ['name' => 'Learnership'],
            ['name' => 'Legal'],
            ['name' => 'Logistics'],
            ['name' => 'Maintenance'],
            ['name' => 'Management'],
            ['name' => 'Manufacturing'],
            ['name' => 'Market Research'],
            ['name' => 'Marketing'],
            ['name' => 'Massage Therapist'],
            ['name' => 'Media'],
            ['name' => 'Medical'],
            ['name' => 'Military'],
            ['name' => 'Mining'],
            ['name' => 'Nanny & Babysitting'],
            ['name' => 'NGO & Non-Profit'],
            ['name' => 'Nursing'],
            ['name' => 'Office'],
            ['name' => 'Oil & Gas'],
            ['name' => 'Online'],
            ['name' => 'Personal Services'],
            ['name' => 'Pharmaceutical'],
            ['name' => 'Photography'],
            ['name' => 'PR & Communication'],
            ['name' => 'Procurement'],
            ['name' => 'Promotion'],
            ['name' => 'Public Sector'],
            ['name' => 'Real Estate'],
            ['name' => 'Receptionist'],
            ['name' => 'Recruitment'],
            ['name' => 'Research'],
            ['name' => 'Retail'],
            ['name' => 'Safety Officer'],
            ['name' => 'Sales'],
            ['name' => 'Secretary'],
            ['name' => 'Security'],
            ['name' => 'Social Work'],
            ['name' => 'Sports'],
            ['name' => 'Student'],
            ['name' => 'Teaching'],
            ['name' => 'Technical'],
            ['name' => 'Technology'],
            ['name' => 'Telecommunications'],
            ['name' => 'Tourism'],
            ['name' => 'Transportation'],
            ['name' => 'Travel'],
            ['name' => 'Urgent'],
            ['name' => 'Utility'],
            ['name' => 'Waitress'],
            ['name' => 'Warehouse'],
            ['name' => 'Web'],
            ['name' => 'Welding'],
            ['name' => 'Wholesale'],
          ];
          
          foreach($jobsectors as $type){

            JobSector::updateOrCreate([ 
                'name' => $type['name'],
                 'slug' => Str::slug($type['name'])
                 ]);
        }
    }
}
