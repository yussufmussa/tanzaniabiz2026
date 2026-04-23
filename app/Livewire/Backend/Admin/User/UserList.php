<?php

namespace App\Livewire\Backend\Admin\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component

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

    public function toggleStatus($userId)
    {
        $user = User::findOrFail($userId);

        $user->is_active = !$user->is_active;
        $user->save();

        $this->dispatch('StatusUpdated', [
            'message' => 'User status is updated successfully!',
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
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when(!auth()->user()->hasRole('admin'), function ($query) {
                $query->whereDoesntHave('roles', function ($q) {
                    $q->where('name', 'admin');
                });
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->where('is_active', $this->statusFilter === 'active' ? 1 : 0);
            })
            ->when($this->businessListing === 'with_business_listings', function ($query) {
                $query->has('businessListings');
            })
            ->when($this->businessListing === 'without_business_listings', function ($query) {
                $query->doesntHave('businessListings');
            })
            ->orderBy('name', 'asc')
            ->withCount('businessListings')
            ->with(['roles.permissions', 'permissions', 'businessListings'])
            ->paginate($this->perPage);

        return view('livewire.backend.admin.user.user-list', compact('users'));
    }
}
