<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class CategoryExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $categories;

    public function __construct($categories)
    {
        $this->categories = $categories;
    }

    public function collection()
    {
        return $this->categories;
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'No. of Business',
            'Status',
        ];
    }

    public function map($category): array
    {
        static $index = 0;
        $index++;

        return [
            $index,
            $category->name,
            $category->business_listings_count,
            $category->is_active ? 'Active' : 'Inactive',
        ];
    }
}
