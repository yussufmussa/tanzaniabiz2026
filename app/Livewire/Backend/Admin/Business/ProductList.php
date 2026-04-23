<?php

namespace App\Livewire\Backend\Admin\Product;

use App\Models\Product\Category;
use App\Models\Product\Product;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    // Filter properties
    public $productId;

    public $search = '';
    public $categoryFilter = '';
    public $destinationFilter = '';
    public $statusFilter = '';
    public $popularFilter = '';

    // Pagination
    protected $paginationTheme = 'bootstrap';


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingDestinationFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingPopularFilter()
    {
        $this->resetPage();
    }

    public function togglePopular($productId)
    {

        $product = Product::findOrFail($productId);
        $product->update(['is_popular' => !$product->is_popular]);

        $this->dispatch('StatusUpdated', [
            'type' => 'success',
            'message' => 'Popular Status Update Successfully',
        ]);
    }

    public function toggleStatus($productId)
    {

        $product = Product::findOrFail($productId);
        $product->update(['is_active' => !$product->is_active]);

        $this->dispatch('StatusUpdated', [
            'type' => 'success',
            'message' => 'Product Status Update Successfully',
        ]);
    }

    public function toggleFeatured($productId)
    {

        $product = Product::findOrFail($productId);
        $product->update(['is_featured' => !$product->is_featured]);

        $this->dispatch('StatusUpdated', [
            'type' => 'success',
            'message' => 'Featured Status Update Successfully',
        ]);
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->categoryFilter = '';
        $this->destinationFilter = '';
        $this->statusFilter = '';
        $this->popularFilter = '';
        $this->resetPage();
    }

    public function render()
    {
        // Get categories for filter dropdown
        $categories = Category::orderBy('name')->get();

        // Build query with filters
        $query = Product::with(['category', 'productPhotos', 'subcategory']);

        // Apply search filter
        if (!empty($this->search)) {
            $query->where('title', 'LIKE', '%' . $this->search . '%');
        }

        // Apply category filter
        if (!empty($this->categoryFilter)) {
            $query->where('category_id', $this->categoryFilter);
        }

        // Apply destination filter
        if (!empty($this->destinationFilter)) {
            $query->where('destination', $this->destinationFilter);
        }

        // Apply status filter
        if ($this->statusFilter !== '') {
            $query->where('is_active', $this->statusFilter === '1');
        }

        // Apply popular filter
        if ($this->popularFilter !== '') {
            $query->where('is_popular', $this->popularFilter === '1');
        }

        $products = $query->latest()->paginate(15);

        return view('livewire.backend.admin.product.product-list', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
}
