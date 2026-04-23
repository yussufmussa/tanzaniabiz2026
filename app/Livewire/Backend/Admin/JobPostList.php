<?php

namespace App\Livewire\Backend\Admin;

use App\Models\Business\City;
use App\Models\Jobs\JobSector;
use App\Models\Jobs\JobType;
use App\Models\Jobs\PostJob;
use Livewire\Component;
use Livewire\WithPagination;

class JobPostList extends Component
{
    use WithPagination;

    public $jobId;

    public $search = '';
    public $categoryFilter = '';
    public $cityFilter = '';
    public $jobSectorFilter = '';
    public $jobTypeFilter = '';


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

    public function updatingjobSectorFilter()
    {
        $this->resetPage();
    }

    public function updatingjobTypeFilter()
    {
        $this->resetPage();
    }


    public function clearFilters()
    {
        $this->search = '';
        $this->categoryFilter = '';
        $this->cityFilter = '';
        $this->jobSectorFilter = '';
        $this->jobTypeFilter = '';
        $this->resetPage();
    }

    public function render()
    {
        $jobSectors = JobSector::orderBy('name')->get();
        $jobTypes = JobType::orderBy('name')->get();
        $cities = City::orderBy('city_name')->get();


        $query = PostJob::with(['city', 'jobSector', 'jobType']);

        if (!empty($this->search)) {
            $query->where('title', 'LIKE', '%' . $this->search . '%');
        }

        if (!empty($this->jobSectorFilter)) {
            $query->where('job_sector_id', $this->jobSectorFilter);
        }

        if (!empty($this->jobTypeFilter)) {
            $query->where('job_type_id', $this->jobTypeFilter);
        }

        if ($this->cityFilter !== '') {
            $query->where('city_id', $this->cityFilter === '1');
        }


        $jobs = $query->latest()->paginate(15);

        return view('livewire.backend.admin.job-post-list', [
            'jobs' => $jobs,
            'cities' => $cities,
            'jobSectors' => $jobSectors,
            'jobTypes' => $jobTypes,
        ]);
    }
}
