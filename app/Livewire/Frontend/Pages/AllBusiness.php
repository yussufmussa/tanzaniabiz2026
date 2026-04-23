<?php

namespace App\Livewire\Frontend\Pages;

use App\Models\Business\BusinessListing;
use App\Models\Business\Category;
use App\Models\Business\City;
use App\Models\Business\SubCategory;
use Livewire\Component;
use Livewire\WithPagination;

class AllBusiness extends Component
{
    use WithPagination;

    public string $pageTitle = 'Businesses in Tanzania';
    public array $breadcrumbs = [];

    public ?string $presetCategorySlug = null;
    public ?string $presetCitySlug = null;
    public ?string $presetKeywords = null;
    public ?string $presetCategoryId = null;
    public ?string $presetCityId = null;



    public array $selectedCategories = [];
    public array $selectedSubCategories = [];
    public string $cityId = '';

    public $subcategories = [];

    protected $paginationTheme = 'bootstrap';


    public function mount($presetCategorySlug = null, $presetCitySlug = null, $presetKeywords = null)
    {
        $this->presetCategorySlug = $presetCategorySlug;
        $this->presetCitySlug = $presetCitySlug;
        $this->presetKeywords = $presetKeywords;

        if ($presetCategorySlug) {
            $catId = Category::where('slug', $presetCategorySlug)->value('id');
            if ($catId) {
                $this->selectedCategories = [$catId];
                $this->updatedSelectedCategories(); // loads subcategories
            }
        }

        if ($presetCitySlug) {
            $cityId = City::where('slug', $presetCitySlug)->value('id');
            if ($cityId) {
                $this->cityId = (string) $cityId;
            }
        }
    }

    public function updatedSelectedCategories()
    {
        $this->resetPage();

        // Only allow subcategory filter when exactly 1 category is selected
        if (count($this->selectedCategories) === 1) {
            $this->subcategories = SubCategory::query()
                ->where('category_id', $this->selectedCategories[0])
                ->where('is_active', 1)
                ->orderBy('name')
                ->get(['id', 'name'])
                ->toArray();
        } else {
            $this->subcategories = [];
            $this->selectedSubCategories = [];
        }
    }

    public function updatedSelectedSubCategories()
    {
        $this->resetPage();
    }

    public function updatedCityId()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->selectedCategories = [];
        $this->selectedSubCategories = [];
        $this->cityId = '';
        $this->subcategories = [];
        $this->resetPage();
    }

    protected function buildHeaderData($activeCategory = null, $activeCity = null)
    {
        // Title
        if ($activeCategory && $activeCity) {
            $this->pageTitle = "{$activeCategory->name} in {$activeCity->city_name}";
        } elseif ($activeCategory) {
            $this->pageTitle = $activeCategory->name;
        } elseif ($activeCity) {
            $this->pageTitle = "Businesses in {$activeCity->city_name}";
        } else {
            $this->pageTitle = "Businesses in Tanzania";
        }

        // Breadcrumbs
        $crumbs = [
            ['label' => 'Home', 'url' => url('/')],
            ['label' => 'Business', 'url' => url('/')],
        ];

        if ($activeCategory) {
            $crumbs[] = [
                'label' => $activeCategory->name,
                'url' => route('business.by.category', $activeCategory->slug),
            ];
        }

        if ($activeCity) {
            $crumbs[] = [
                'label' => $activeCity->city_name,
                'url' => route('business.by.city', $activeCity->slug),
            ];
        }

        $this->breadcrumbs = $crumbs;
    }

    public function render()
    {
        $top_categories = Category::query()
            ->orderBy('name')
            ->withCount('business_listings')
            ->get(['id', 'name']);

        $cities = City::query()
            ->orderBy('city_name')
            ->get(['id', 'city_name', 'slug']);

        $business = BusinessListing::query()
            ->where('status', 1)
            ->with(['category:id,name', 'city:id,city_name', 'subCategories:id,name'])
            ->when(!empty($this->selectedCategories), function ($q) {
                $q->whereIn('category_id', $this->selectedCategories);
            })
            ->when($this->cityId !== '', function ($q) {
                $q->where('city_id', $this->cityId);
            })
            ->when(!empty($this->selectedSubCategories), function ($q) {
                $q->whereHas('subCategories', function ($qq) {
                    $qq->whereIn('sub_categories.id', $this->selectedSubCategories);
                });
            })
            ->latest()
            ->paginate(15);

        $activeCategory = null;
        $activeCity = null;

        if (count($this->selectedCategories) === 1) {
            $activeCategory = Category::select('id', 'name', 'slug')
                ->find($this->selectedCategories[0]);
        }

        // Active city
        if ($this->cityId !== '') {
            $activeCity = City::select('id', 'city_name', 'slug')
                ->find($this->cityId);
        }

        $this->buildHeaderData($activeCategory, $activeCity);

        return view('livewire.frontend.pages.all-business', compact(
            'business',
            'top_categories',
            'cities'
        ));
    }
}
