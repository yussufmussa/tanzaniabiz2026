<?php

namespace App\Livewire\Backend\Admin;

use App\Models\Coupon;
use Livewire\Component;
use Livewire\WithPagination;

class CouponList extends Component
{
     use WithPagination;

    public $search = '';
    public $statusFilter = 'all'; 
    public $couponFilter = 'all'; 
    public $perPage = 15;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
        'couponFilter' => ['except' => 'all'],
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

    public function toggleStatus($couponId)
    {
        $coupon = Coupon::findOrFail($couponId);
        $coupon->is_active = !$coupon->is_active;
        $coupon->save();

        $this->dispatch('StatusUpdated', [
            'message' => 'Coupon status is updated successfully!',
            'type' => 'success',
        ]);
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->statusFilter = 'all';
        $this->couponFilter = 'all';
        $this->resetPage();
    }

    public function render()
    {
        $coupons = Coupon::query()
            ->when($this->search, function ($query) {
                $query->where('code', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->where('is_active', $this->statusFilter === 'active' ? 1 : 0);
            })
            ->when($this->couponFilter === 'with_orders', function ($query) {
                $query->has('orders');
            })
            ->when($this->couponFilter === 'without_orders', function ($query) {
                $query->doesntHave('orders');
            })
            ->orderBy('code', 'asc')
            ->withCount('orders')
            ->paginate($this->perPage);

        return view('livewire.backend.admin.coupon-list', compact('coupons'));
        
    }

}
