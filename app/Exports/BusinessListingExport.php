<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BusinessListingExport implements FromCollection, WithHeadings
{
    protected $listings;

    public function __construct($listings)
    {
        $this->listings = $listings;
    }

    public function collection(): Collection
    {
        return $this->listings->map(function ($listing, $index) {
            return [
                $index + 1,
                $listing->name,
                $listing->category->name ?? '-',
                $listing->city->city_name ?? '-',
                $listing->email,
                $listing->is_featured ? 'Yes' : 'No',
                $listing->status ? 'Active' : 'Inactive',
            ];
        });
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Category',
            'City',
            'Email',
            'Is Featured',
            'Status',
        ];
    }
}