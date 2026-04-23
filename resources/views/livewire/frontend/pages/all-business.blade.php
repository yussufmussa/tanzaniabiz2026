<div>

    {{-- Header / Breadcrumb --}}
    <div class="row mb-2" style="margin-top: 0 !important;">
        <div class="col-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    @foreach ($breadcrumbs as $i => $crumb)
                        @if ($i === count($breadcrumbs) - 1)
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $crumb['label'] }}
                            </li>
                        @else
                            <li class="breadcrumb-item">
                                <a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a>
                            </li>
                        @endif
                    @endforeach
                </ol>
            </nav>

            <h1 class="ft-bold mb-2">{{ $pageTitle }}</h1>

            <div class="d-block grouping-listings-title">
                <h3 class="ft-medium mb-0">{{ $business->total() }} company(s) found</h3>
            </div>

        </div>
    </div>

    <div class="row">

        {{-- LEFT FILTER SIDEBAR --}}
        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">

            {{-- Mobile filter button --}}
            <div class="d-md-none mb-3">
                <button class="btn btn-outline-primary w-100" type="button" data-bs-toggle="collapse"
                    data-bs-target="#listingFilters" aria-expanded="false">
                    <i class="lni lni-funnel me-1"></i> Filters
                </button>
            </div>

            <div class="bg-white rounded mb-4">

                <div class="sidebar_header d-flex align-items-center justify-content-between px-4 py-3 br-bottom">
                    <h4 class="ft-medium fs-lg mb-0">Search Filter</h4>

                    <div class="ssh-header d-flex align-items-center gap-2">
                        <a href="javascript:void(0);" class="clear_all ft-medium text-muted" wire:click="clearFilters">
                            Clear All
                        </a>

                        {{-- Desktop toggle icon --}}
                        <a href="#listingFilters" data-bs-toggle="collapse" aria-expanded="true" role="button"
                            class="_filter-ico ml-2 d-none d-md-inline-block">
                            <i class="lni lni-text-align-right"></i>
                        </a>
                    </div>
                </div>

                <div id="listingFilters" class="collapse d-md-block">
                    <div class="search-inner">
                        <div class="side-filter-box">
                            <div class="side-filter-box-body p-3">

                                {{-- City --}}
                                <div class="inner_widget_link mb-3">
                                    <h6 class="ft-medium">City</h6>
                                    <select class="form-control" wire:model.live="cityId">
                                        <option value="">All cities</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Categories --}}
                                <div class="inner_widget_link mb-3">
                                    <h6 class="ft-medium">Search By Category</h6>
                                    <ul class="no-ul-list filter-list">
                                        @foreach ($top_categories as $key => $category)
                                            <li>
                                                <input wire:model.live="selectedCategories" id="C{{ $key }}"
                                                    class="checkbox-custom" type="checkbox" value="{{ $category->id }}">
                                                <label for="C{{ $key }}" class="checkbox-custom-label">
                                                    {{ $category->name }}
                                                    <span class="text-muted">
                                                        ({{ $category->business_listings_count ?? 0 }})
                                                    </span>
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                {{-- Subcategories (only when exactly 1 category selected) --}}
                                @if (count($selectedCategories) === 1)
                                    <div class="inner_widget_link">
                                        <h6 class="ft-medium">Subcategories</h6>

                                        <ul class="no-ul-list filter-list">
                                            @forelse($subcategories as $i => $sub)
                                                <li>
                                                    <input wire:model.live="selectedSubCategories"
                                                        id="SC{{ $i }}" class="checkbox-custom"
                                                        type="checkbox" value="{{ $sub['id'] ?? $sub->id }}">
                                                    <label for="SC{{ $i }}" class="checkbox-custom-label">
                                                        {{ $sub['name'] ?? $sub->name }}
                                                    </label>
                                                </li>
                                            @empty
                                                <li class="text-muted small">No subcategories found.</li>
                                            @endforelse
                                        </ul>

                                        <div class="small text-muted mt-2">
                                            Tip: Select one category to filter by subcategory.
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- CENTER LISTINGS --}}
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">

            {{-- Loading --}}
            <div wire:loading class="mb-3">
                <img src="https://tanzaniabiz.com/uploads/general/loader.gif" alt="Loading..." />
            </div>

            <div class="d-block grouping-listings">

                @forelse($business as $listing)
    @php
        $logo = $listing->logo
            ? asset('uploads/businessListings/logos/' . $listing->logo)
            : asset('upload/general/default.png');

        $subs = $listing->subCategories ?? collect();

        // "New" indicator (example: within last 7 days)
        $isNew = $listing->created_at && $listing->created_at->gte(now()->subDays(7));
    @endphp

    {{-- LIST ITEM --}}
    <div class="grouping-listings-single bg-white py-3"
         style="border-bottom:1px solid #eef1f6;">

        <div class="d-flex gap-3 align-items-start">

            {{-- Logo --}}
            <div class="flex-shrink-0">
                <img src="{{ $logo }}"
                     class="rounded"
                     alt="{{ $listing->name }}"
                     style="width:64px;height:64px;object-fit:cover;">
            </div>

            {{-- Content --}}
            <div class="flex-grow-1" style="min-width:0;">

                <div class="d-flex justify-content-between gap-2 align-items-start">
                    <div style="min-width:0;">
                        <h4 class="mb-1 ft-medium" style="line-height:1.2;">
                            <a href="{{ route('listing.details', $listing->slug) }}"
                               class="text-dark fs-md"
                               style="display:inline-block;max-width:100%;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ $listing->name }}
                            </a>

                            @if(!empty($listing->is_verified))
                                <span class="verified-badge ms-1" title="Verified">
                                    <i class="fas fa-check-circle"></i>
                                </span>
                            @endif

                        </h4>

                        {{-- Meta line --}}
                        <div class="text-muted small d-flex flex-wrap gap-3">
                            <span><i class="lni lni-map-marker me-1"></i>{{ $listing->location }}</span>
                            <span><i class="lni lni-tag me-1"></i>{{ $listing->category->name }}</span>
                            <span><i class="lni lni-pin me-1"></i>{{ $listing->city->city_name }}</span>
                        </div>

                        {{-- Subcategories (optional, keep compact) --}}
                        @if($subs->count())
                            <div class="mt-2 d-flex flex-wrap gap-2">
                                @foreach($subs->take(2) as $sub)
                                    <span class="badge bg-light text-dark border">{{ $sub->name }}</span>
                                @endforeach
                                @if($subs->count() > 2)
                                    <span class="badge bg-light text-dark border">+{{ $subs->count() - 2 }}</span>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- Right side tag --}}
                    @if($listing->is_featured)
                        <span class="badge bg-warning text-dark" style="white-space:nowrap;">Featured</span>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="mt-2 d-flex flex-wrap gap-2 small">

    <a href="{{ route('listing.details', $listing->slug) }}"
       class="badge bg-info text-white text-decoration-none px-2 py-1">
        View
    </a>

    @if ($listing->phone)
        <a href="tel:{{ $listing->phone }}"
           class="badge bg-light text-dark border text-decoration-none px-2 py-1">
            Call
        </a>
    @endif

    @if ($listing->website)
        <a href="{{ $listing->website }}"
           target="_blank"
           rel="nofollow noopener"
           class="badge theme-bg text-white text-decoration-none px-2 py-1">
            Website
        </a>
    @endif

</div>

            </div>
        </div>
    </div>

@empty
    <div class="bg-white rounded p-4 text-center">
        No businesses found for these filters.
    </div>
@endforelse

            </div>

            {{-- Pagination (Livewire-friendly) --}}
            @if ($business->hasPages())
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($business->onFirstPage())
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span class="fas fa-arrow-circle-right"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $business->previousPageUrl() }}" aria-label="Next">
                                    <span class="fas fa-arrow-circle-right"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        @endif
                        {{-- Pagination Elements --}}
                        @if ($business->lastPage() > 1)
                            @for ($i = max(1, $business->currentPage() - 2); $i <= min($business->lastPage(), $business->currentPage() + 2); $i++)
                                <li class="page-item">
                                    <a class="{{ $business->currentPage() == $i ? ' page-link page-link-active' : 'page-link' }}"
                                        href="{{ $business->url($i) }}">{{ $i }}</a>
                                </li>
                            @endfor
                        @endif

                        {{-- Next Page Link --}}
                        @if ($business->hasMorePages())
                            <li class="page-item"><a class="page-link"
                                    href="{{ $business->nextPageUrl() }}">Next</a></li>
                        @else
                            <li class="page-item disabled"><a class="page-link"
                                    href="{{ $business->nextPageUrl() }}">Last</a></li>
                        @endif
                    </ul>
            @endif

            {{-- CTA --}}
            <div class="mt-4">
                <div class="list-411">
                    <div class="list-412">
                        <h4 class="ft-bold mb-0">Can't find the business?</h4>
                        <span>Adding a business to Tanzania Biz is always free.</span>
                    </div>
                    <div class="list-413">
                        <a class="btn text-light theme-bg rounded" href="/register">Add your business for free</a>
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT ADS --}}
        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
            <div class="bg-white rounded mb-4">
                <div class="sidebar_header d-flex align-items-center justify-content-between px-4 py-3 br-bottom">
                    <h4 class="ft-medium fs-lg mb-0">Ads</h4>
                </div>

                <div class="p-3">
                    {{-- Put your ads widgets here --}}
                </div>
            </div>
        </div>

    </div>

</div>
