<?php

namespace App\Livewire\Backend\Admin\Business;

use App\Mail\BusinessListingApprovedMail;
use App\Models\Business\BusinessListing;
use App\Models\Business\Category;
use App\Models\Business\City;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class BusinessListingList extends Component
{
    use WithPagination;

    public $businessListingId;

    public $search = '';
    public $categoryFilter = '';
    public $cityFilter = '';
    public $statusFilter = '';

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

    public function updatingCityFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }


    public function toggleStatus($businessListingId)
    {
        $listing = BusinessListing::findOrFail($businessListingId);
        $beforeStatus = $listing->status;

        $listing->status = $listing->status == 0 ? 1 : 0;
        $success = $listing->save();

        if ($beforeStatus == 0 && $listing->status == 1 && $success) {
            try {
                Mail::to($listing->user->email)->send(new BusinessListingApprovedMail($listing));
            } catch (\Throwable $th) {

                Log::info('there is an error' . $th->getMessage());
            }
        }
        $this->dispatch('StatusUpdated', [
            'type' => 'success',
            'message' => 'Business Listing activated Successfully',
        ]);
    }



    public function clearFilters()
    {
        $this->search = '';
        $this->categoryFilter = '';
        $this->cityFilter = '';
        $this->statusFilter = '';
        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::orderBy('name')->get();
        $cities = City::orderBy('city_name')->get();


        $query = BusinessListing::with(['category', 'photos', 'city', 'products']);

        if (!empty($this->search)) {
            $query->where('name', 'LIKE', '%' . $this->search . '%');
        }

        if (!empty($this->categoryFilter)) {
            $query->where('category_id', $this->categoryFilter);
        }

        if ($this->cityFilter !== '') {
            $query->where('city_id', $this->cityFilter === '1');
        }


        if ($this->statusFilter !== '') {
            $query->where('status', $this->statusFilter === '1');
        }

        $products = $query->latest()->paginate(15);

        return view('livewire.backend.admin.business.business-listing-list', [
            'listings' => $products,
            'categories' => $categories,
            'cities' => $cities,
        ]);
    }
}
