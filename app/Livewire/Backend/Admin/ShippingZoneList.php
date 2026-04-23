<?php

namespace App\Livewire\Backend\Admin;

use App\Models\ShippingZone;
use Livewire\Component;
use Livewire\WithPagination;

class ShippingZoneList extends Component
{


    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';
    public $shippingZoneFilter = 'all';
    public $perPage = 15;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => 'all'],
        'shippingZoneFilter' => ['except' => 'all'],
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

    public function toggleStatus($shippingZoneId)
    {
        $shippingZone = ShippingZone::findOrFail($shippingZoneId);
        $shippingZone->is_active = !$shippingZone->is_active;
        $shippingZone->save();

        $this->dispatch('StatusUpdated', [
            'message' => 'Shipping Zone status is updated successfully!',
            'type' => 'success',
        ]);
    }

    public function toggleDefault($shippingZoneId)
    {
        $shippingZone = ShippingZone::findOrFail($shippingZoneId);

        if (! $shippingZone->is_default) {
            ShippingZone::where('is_default', true)
                ->update(['is_default' => false]);

            $shippingZone->is_default = true;
            $shippingZone->save();

            $this->dispatch('StatusUpdated', [
                'message' => 'Shipping zone set as default successfully!',
                'type' => 'success',
            ]);
        } else {
            $this->dispatch('StatusUpdated', [
                'message' => 'This shipping zone is already the default.',
                'type' => 'info',
            ]);
        }
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->statusFilter = 'all';
        $this->shippingZoneFilter = 'all';
        $this->resetPage();
    }

    public function render()
    {
        $shippingZones = ShippingZone::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->where('is_active', $this->statusFilter === 'active' ? 1 : 0);
            })
            ->when($this->shippingZoneFilter === 'with_orders', function ($query) {
                $query->has('orders');
            })
            ->when($this->shippingZoneFilter === 'without_orders', function ($query) {
                $query->doesntHave('orders');
            })
            ->orderBy('name', 'asc')
            ->withCount('orders')
            ->paginate($this->perPage);

        return view('livewire.backend.admin.shipping-zone-list', compact('shippingZones'));
    }
}
