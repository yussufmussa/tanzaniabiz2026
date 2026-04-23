<?php

namespace App\Livewire\Backend;

use App\Models\LoginHistory;
use Livewire\Component;
use Livewire\WithPagination;

class LoginHistoryList extends Component
{
     use WithPagination;

    public string $search = '';
    public ?string $date_from = null;
    public ?string $date_to = null;
    public ?string $device_type = null;
    public int $per_page = 15;
    public string $sort = 'login_time';
    public string $direction = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'date_from' => ['except' => ''],
        'date_to' => ['except' => ''],
        'device_type' => ['except' => ''],
        'per_page' => ['except' => 15],
        'sort' => ['except' => 'login_time'],
        'direction' => ['except' => 'desc'],
        'page' => ['except' => 1],
    ];

    public function updating($field)
    {
        if (in_array($field, ['search', 'date_from', 'date_to', 'device_type', 'per_page'])) {
            $this->resetPage();
        }
    }


    public function sortBy($field)
    {
        if ($this->sort === $field) {
            $this->direction = $this->direction === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort = $field;
            $this->direction = 'asc';
        }
    }

    public function setQuickFilter($days)
    {
        $today = now();
        $fromDate = $today->copy()->subDays($days)->format('Y-m-d');
        $this->date_from = $fromDate;
        $this->date_to = $today->format('Y-m-d');
    }

    public function resetFilters()
    {
        $this->reset([
            'search',
            'date_from',
            'date_to',
            'device_type',
            'per_page',
            'sort',
            'direction',
        ]);
        $this->sort = 'login_time';
        $this->direction = 'desc';
        $this->resetPage();
    }


    public function exportPdf()
    {
        return redirect()->route('login.history.export.pdf', [
            'search' => $this->search,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'device_type' => $this->device_type,
            'sort' => $this->sort,
            'direction' => $this->direction
        ]);
    }

     public function exportExcel()
    {
        return redirect()->route('login.history.export.excel');
    }



    protected function getFilteredQuery()
    {
        $query = LoginHistory::with('user');

        // Search
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->whereHas('user', function ($sub) {
                    $sub->where('email', 'like', "%{$this->search}%")
                        ->orWhere('name', 'like', "%{$this->search}%");
                })->orWhere('ip_address', 'like', "%{$this->search}%");
            });
        }

        // Date Range
        if (!empty($this->date_from)) {
            $query->whereDate('login_time', '>=', $this->date_from);
        }

        if (!empty($this->date_to)) {
            $query->whereDate('login_time', '<=', $this->date_to);
        }

        // Device Type
        if (!empty($this->device_type)) {
            $query->where(function ($q) {
                switch ($this->device_type) {
                    case 'mobile':
                        $q->where('user_agent', 'like', '%Mobile%')
                            ->orWhere('user_agent', 'like', '%Android%')
                            ->orWhere('user_agent', 'like', '%iPhone%');
                        break;
                    case 'tablet':
                        $q->where('user_agent', 'like', '%iPad%')
                            ->orWhere('user_agent', 'like', '%Tablet%');
                        break;
                    case 'desktop':
                        $q->where('user_agent', 'not like', '%Mobile%')
                            ->where('user_agent', 'not like', '%Android%')
                            ->where('user_agent', 'not like', '%iPhone%')
                            ->where('user_agent', 'not like', '%iPad%')
                            ->where('user_agent', 'not like', '%Tablet%');
                        break;
                }
            });
        }

        // Sorting
        $allowedSorts = ['login_time', 'ip_address', 'email', 'name'];
        if (!in_array($this->sort, $allowedSorts)) {
            $this->sort = 'login_time';
        }

        if (in_array($this->sort, ['email', 'name'])) {
            $query->join('users', 'login_histories.user_id', '=', 'users.id')
                ->select('login_histories.*')
                ->orderBy("users.{$this->sort}", $this->direction);
        } else {
            $query->orderBy($this->sort, $this->direction);
        }

        return $query;
    }

    public function render()
    {
        $logins = $this->getFilteredQuery()->paginate($this->per_page);

        return view('livewire.backend.login-history-list', [
            'logins' => $logins,
        ]);
    }

}
