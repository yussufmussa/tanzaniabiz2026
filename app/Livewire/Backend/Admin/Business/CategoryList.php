<?php

namespace App\Livewire\Backend\Admin\Business;

use App\Models\Business\Category;
use Livewire\Component;
use Livewire\WithPagination;


class CategoryList extends Component
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

    public function toggleStatus($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $category->is_active = !$category->is_active;
        $category->save();

        $this->dispatch('StatusUpdated', [
            'message' => 'Category status is updated successfully!',
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
        $categories = Category::query()
            ->select(['id', 'name', 'icon', 'is_active'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->where('is_active', $this->statusFilter === 'active' ? 1 : 0);
            })
            ->when($this->productFilter === 'with_products', function ($query) {
                $query->has('business_listings');
            })
            ->when($this->productFilter === 'without_products', function ($query) {
                $query->doesntHave('business_listings');
            })
            ->orderBy('name', 'asc')
            ->withCount('business_listings')
            ->paginate($this->perPage);

        return view('livewire.backend.admin.business.category-list', compact('categories'));
    }

}
