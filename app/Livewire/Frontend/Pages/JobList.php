<?php

namespace App\Livewire\Frontend\Pages;

use App\Models\Business\City;
use App\Models\Jobs\JobSector;
use App\Models\Jobs\JobType;
use App\Models\Jobs\PostJob;
use Livewire\Component;
use Livewire\WithPagination;

class JobList extends Component
{
     use WithPagination;

    public ?string $presetSectorSlug = null;
    public ?string $presetTypeSlug = null;
    public ?string $presetCitySlug = null;

    public $sectorId = '';
    public $typeId   = '';
    public $cityId   = '';

    public function mount($presetSectorSlug = null, $presetTypeSlug = null, $presetCitySlug = null)
    {
        $this->presetSectorSlug = $presetSectorSlug;
        $this->presetTypeSlug   = $presetTypeSlug;
        $this->presetCitySlug   = $presetCitySlug;

        if ($presetSectorSlug) {
            $this->sectorId = JobSector::where('slug', $presetSectorSlug)->value('id') ?? '';
        }
        if ($presetTypeSlug) {
            $this->typeId = JobType::where('slug', $presetTypeSlug)->value('id') ?? '';
        }
        if ($presetCitySlug) {
            $this->cityId = City::where('slug', $presetCitySlug)->value('id') ?? '';
        }
    }

    public function updated($field)
    {
        // reset pagination when any filter changes
        if (in_array($field, ['sectorId','typeId','cityId'])) {
            $this->resetPage();
        }
    }

    public function clearFilters()
    {
        $this->sectorId = '';
        $this->typeId   = '';
        $this->cityId   = '';
        $this->resetPage();
    }

    public function render()
    {
        $sectors = JobSector::orderBy('name')->get();
        $types   = JobType::orderBy('name')->get();
        $cities  = City::orderBy('city_name')->get();

        $jobs = PostJob::query()
            ->with(['jobSector', 'jobType', 'city'])
            ->when($this->sectorId, fn($q) => $q->where('job_sector_id', $this->sectorId))
            ->when($this->typeId,   fn($q) => $q->where('job_type_id', $this->typeId))
            ->when($this->cityId,   fn($q) => $q->where('city_id', $this->cityId))
            ->latest()
            ->paginate(30);

        return view('livewire.frontend.pages.job-list', compact('jobs', 'sectors', 'types', 'cities'));
    }
}
