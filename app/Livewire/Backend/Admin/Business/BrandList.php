<?php

namespace App\Livewire\Backend\Admin\Product;

use App\Models\Product\Brand;
use Livewire\Component;
use Livewire\WithPagination;

class BrandList extends Component
{
     use WithPagination;

    public $search = '';
    public $statusFilter = 'all'; 
    public $productFilter = 'all'; 
    public $perPage = 15;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
        'productFilter' => ['except' => 'all'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingProductFilter()
    {
        $this->resetPage();
    }

    public function toggleStatus($brandId)
    {
        $brand = Brand::findOrFail($brandId);
        $brand->is_active = !$brand->is_active;
        $brand->save();

        $this->dispatch('StatusUpdated', [
            'message' => 'Brand status is updated successfully!',
            'type' => 'success',
        ]);
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->statusFilter = 'all';
        $this->productFilter = 'all';
        $this->resetPage();
    }

    public function render()
    {
        $brands = Brand::query()
            ->select(['id', 'name', 'photo', 'is_active'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->where('is_active', $this->statusFilter === 'active' ? 1 : 0);
            })
            ->when($this->productFilter === 'with_products', function ($query) {
                $query->has('products');
            })
            ->when($this->productFilter === 'without_products', function ($query) {
                $query->doesntHave('products');
            })
            ->orderBy('name', 'asc')
            ->withCount('products')
            ->paginate($this->perPage);

        return view('livewire.backend.admin.product.brand-list', compact('brands'));
    }

}
