<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportSubCategory implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
   protected $subcategories;

    public function __construct($subcategories)
    {
        $this->subcategories = $subcategories;
    }

    public function collection()
    {
        return $this->subcategories;
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

    public function map($subcategory): array
    {
        static $index = 0;
        $index++;

        return [
            $index,
            $subcategory->name,
            $subcategory->business_listings_count,
            $subcategory->is_active ? 'Active' : 'Inactive',
        ];
    }
}
