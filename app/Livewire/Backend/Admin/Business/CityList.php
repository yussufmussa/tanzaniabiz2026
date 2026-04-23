<?php

namespace App\Livewire\Backend\Admin\Business;

use App\Models\Business\City;
use Livewire\Component;
use Livewire\WithPagination;

class CityList extends Component
{
   use WithPagination;

    public $search = '';
    public $statusFilter = 'all'; 
    public $businessListing = 'all'; 
    public $perPage = 15;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
        'businessListing' => ['except' => 'all'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingbusinessListing()
    {
        $this->resetPage();
    }

    public function toggleStatus($cityId)
    {
        $city = City::findOrFail($cityId);
        $city->is_active = !$city->is_active;
        $city->save();

        $this->dispatch('StatusUpdated', [
            'message' => 'City status is updated successfully!',
            'type' => 'success',
        ]);
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->statusFilter = 'all';
        $this->businessListing = 'all';
        $this->resetPage();
    }

    public function render()
    {
        $cities = City::query()
            ->select(['id', 'city_name', 'is_active'])
            ->when($this->search, function ($query) {
                $query->where('city_name', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->where('is_active', $this->statusFilter === 'active' ? 1 : 0);
            })
            ->when($this->businessListing === 'with_business_listings', function ($query) {
                $query->has('business_listings');
            })
            ->when($this->businessListing === 'without_business_listings', function ($query) {
                $query->doesntHave('business_listings');
            })
            ->orderBy('city_name', 'asc')
            ->withCount('business_listings')
            ->paginate($this->perPage);

        return view('livewire.backend.admin.business.city-list', compact('cities'));
    }
}
