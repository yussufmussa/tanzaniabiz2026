<?php

namespace App\Livewire\Backend\Admin;

use App\Models\BusinessEvent;
use Livewire\Component;
use Livewire\WithPagination;

class EventList extends Component
{
    use WithPagination;

    public $eventId;

    public $search = '';


    // Pagination
    protected $paginationTheme = 'bootstrap';


    public function updatingSearch()
    {
        $this->resetPage();
    }



    public function clearFilters()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function render()
    {
       
        $query = BusinessEvent::query();

        if (!empty($this->search)) {
            $query->where('title', 'LIKE', '%' . $this->search . '%');
        }


        $events = $query->latest()->paginate(15);

        return view('livewire.backend.admin.event-list', [
            'events' => $events,
        ]);
    }
}
