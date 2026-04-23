<?php

namespace Database\Seeders;

use App\Models\Business\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $categories = [

            [
                'category' => 'Advertising and Marketing',
                'icon' => 'fas fa-rectangle-ad',
                'subcategories' => ['Advertising agencies', 'Branding Services', 'Graphic design companies', 'Digital Marketing', 'Print Advertising', 'Social Media Marketing', 'Market Research']
            ],

            [
                'category' => 'Agriculture and Farming',
                'icon' => 'fas fa-tractor',
                'subcategories' => ['Agricultural Equipment', 'Farming Consultation', 'Irrigation Equipment', 'Poultry Equipment', 'Green houses', 'Agribusiness', 'Agrochemicals & Pesticides', ' Aquaculture Equipment & Supplies'],
            ],
            [
                'category' => 'Apparel and Fashion',
                'icon' => 'fa-solid fa-sign-hanging',
                'subcategories' => [' Athletic & Sports Wear', 'Bridal Wear & Accessories', 'Children & Infant Clothing', 'Fashion Accessories', 'Foot Wear', "Men's Wear", 'School Uniforms & Other Uniforms', "Women's Wear"]
            ],
            [
                'category' => 'Business Services',
                'icon' => 'fa-solid fa-sign-hanging',
                'subcategories' => ['AC Repair Services ', 'Business Centres ', 'Cleaning Services', 'Commercial Equipment Suppliers ', 'Borehole Drillers', 'Brokers', 'Business to Business Services', ' Filing & Secretarial Services', ' Human Resource Services', 'Inspection & Certification', ' Printing & Publishing', 'Procurement & Outsourcing', 'General Business', 'Fire Safety Consultants', 'Overseas Business', 'Cleaning Equipment & Services', 'Retail Services', 'Security Services', 'Small Business'],
            ],
            [
                'category' => 'Computers & Internet',
                'icon' => 'fas fa-laptop',
                'subcategories' => ['Bulk SMS Providers ', 'Data Recovery Services', 'Computer Repair', 'Computer Training ', 'Information Technology', 'Domain Name Registration', 'Email Providers', 'Computer Shops', 'Computer Consumables', 'Networking', 'Web development', 'Web Design', 'Fintech', 'EduTech', 'AgTech', 'E-learning', 'Cloud Computing', 'Cyber Security', 'Communications', 'Machine Learning', 'Artificatial Intelligence', 'Computer Hardware', 'Software Applications', 'Web Hosting', 'Internet Service Providers', 'Online Content', 'Software Solutions', 'Mobile Apps'],
            ],
            [
                'category' => 'Education and Training',
                'icon' => 'fas fa-graduation-cap',
                'subcategories' => ['Colleges', 'Universities', 'Driving Schools', 'International Schools', 'Languages School', 'Language Schools', 'Primary School', 'Nursery and  Kindergarten', 'High Schools', 'Online Courses']
            ],
            [
                'category' => 'Entertainment & Media',
                'icon' => 'fas fa-film',
                'subcategories' => ['Amusement Parks', 'Arts & Crafts Shops', 'Sports', 'Leisure', 'Photography', 'Film & Tv Productions'],
            ],
            [
                'category' => 'Events and Conferences',
                'icon' => 'fas fa-calendar-alt',
                'subcategories' => ['Conference Facilities ', 'Event Planners & Organizers', 'Wedding Venues ', 'Wedding Planners', 'Event Spaces & Venues']
            ],
            [
                'category' => 'Finance and Insurance',
                'icon' => 'fas fa-dollar-sign',
                'subcategories' => ['Accountants & Auditors ', 'Insurance Companies ', 'Banks', 'Investment Companies', 'Microfinance Institutions ', 'Money Lenders', 'Saccos', 'Stock Brokers', 'Business Management Consulting Firms', 'Insurance Brokers & Agencies', 'Tax Consultants', 'Financial Activity']
            ],
            [
                'category' => 'Food and Drink',
                'icon' => 'fas fa-utensils',
                'subcategories' => ['Butcheries', 'Cafes', 'Caterers & Chefs', 'Catering Equipment Suppliers', 'Restaurants','Supermarket', 'Catering', 'Food Manufacturing', 'Beverage Suppliers', 'Local Foods']
            ],
            [
                'category' => 'Government and Public Services',
                'icon' => 'fas fa-university',
                'subcategories' => ['Government Offices', 'Public Libraries', 'Civic Services', 'Public Transportation', 'Community Centers', 'Nonprofit Organizations', 'Religous Institutions', 'Associations']
            ],
            [
                'category' => 'Health & Beauty',
                'icon' => 'fas fa-heart',
                'subcategories' => ['Hospitals & Clinics', 'Beauty Salons', 'Fitness Centers', 'Spa & Wellness', 'Nutrition Services', 'Massage Therapists', 'Medical Equipment', 'Health Care', 'Pharmacies', 'Beauty Products', 'Hairdressers', 'Dentists', 'Chiropractors', 'Diagnostic Centres', 'Counselling Services ', 'Gynecologists', 'Health Centres']
            ],
            [
                'category' => 'Law and Legal',
                'icon' => 'fas fa-gavel',
                'subcategories' => ['Law Firms', 'Lawyers', 'Legal Tech Companies', 'Legal Services', 'Legal Aid', 'Mediation Services', 'Notary Services']
            ],
            [
                'category' => 'Property & Real Estate',
                'icon' => 'fas fa-home',
                'subcategories' => ['Real Estate Agencies', 'Property Appraisal', 'Property Management', 'Home Inspection', 'Real Estate Development', 'Building Maintenance Services', 'Realtors', 'Interior Design Companies', 'WareHouse', 'Vacation Rentals', 'Letting Agents', 'Rental Properties', 'Apartment Rentals', 'Construction Machinery and Equipment', 'Architectural Services']
            ],
            [
                'category' => 'Manufacturing and Industrial',
                'icon' => 'fas fa-industry',
                'subcategories' => ['Industrial Supplies', 'Processing Machines & Equipment', 'Factory Production', 'Manufacturing Consultation', 'Product Design', 'Quality Control']
            ],
            [
                'category' => 'Tourism and Travel',
                'icon' => 'fas fa-plane',
                'subcategories' => ['Tour Operators', 'Hotels', 'Air BnB', 'Travel Agencies', 'Travel Insurance', 'Attractions', 'Guest Houses', 'Car Rentals', 'Campsite', 'Mount Climbing', 'AirLines']
            ],
            [
                'category' => 'Transportation and Logistics',
                'icon' => 'fas fa-shipping-fast',
                'subcategories' => ['Transportation Services', 'Shipping & Logistics', 'Warehousing', 'Courier Services', 'Air Transport', 'Shipping & Port Agent']
            ],
        ];


        foreach ($categories as $category) {
            $removeSpecialCharacter = str_replace('&', 'and', $category['category']);
            $slugWithAnd = Str::slug($removeSpecialCharacter);
            $mainCategory = Category::create(['name' => $category['category'], 'icon' => $category['icon'], 'slug' => $slugWithAnd]);

            foreach ($category['subcategories'] as $subcategoryName) {
                $removeSpecialCharacter = str_replace('&', 'and', $subcategoryName);
                $slugWithAnd = Str::slug($removeSpecialCharacter);
                $mainCategory->subcategories()->create(['name' => $subcategoryName, 'slug' => $slugWithAnd]);
            }
        }
    }
}
