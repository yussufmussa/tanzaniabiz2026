<div>

    {{-- ================= MOBILE FILTER BUTTON ================= --}}
    <div class="d-md-none mb-3">
        <button
            class="btn btn-outline-primary w-100"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mobileJobFilters"
            aria-expanded="false"
        >
            <i class="lni lni-funnel me-1"></i>
            Filter jobs
        </button>
    </div>

    {{-- ================= FILTER PANEL ================= --}}
    <div
        id="mobileJobFilters"
        class="collapse d-md-block mb-3"
    >
        <div class="bg-white rounded p-3">

            <div class="row g-2 align-items-end">

                {{-- Sector --}}
                <div class="col-md-4">
                    <label class="form-label mb-1">Sector</label>
                    <select class="form-control" wire:model.live="sectorId">
                        <option value="">All sectors</option>
                        @foreach($sectors as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Job Type --}}
                <div class="col-md-4">
                    <label class="form-label mb-1">Job type</label>
                    <select class="form-control" wire:model.live="typeId">
                        <option value="">All types</option>
                        @foreach($types as $t)
                            <option value="{{ $t->id }}">{{ $t->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- City --}}
                <div class="col-md-4">
                    <label class="form-label mb-1">City</label>
                    <select class="form-control" wire:model.live="cityId">
                        <option value="">All cities</option>
                        @foreach($cities as $c)
                            <option value="{{ $c->id }}">{{ $c->city_name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Clear + Count --}}
                <div class="col-12 d-flex gap-2 mt-2">
                    <button
                        type="button"
                        class="btn btn-sm btn-light border"
                        wire:click="clearFilters"
                    >
                        Clear
                    </button>

                    <div class="ms-auto small text-muted">
                        Showing {{ $jobs->total() }} jobs
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ================= JOBS GRID ================= --}}
    <div class="row justify-content-center">

        @forelse ($jobs as $job)
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="_jb_list72">

                    <div class="_jb_list72_flex">
                        <div class="_jb_list72_last">

                            <h4 class="_jb_title">
                                <a href="{{ route('job.detail', ['slug' => $job->slug]) }}">
                                    {{ $job->title }}
                                </a>
                            </h4>

                            <div class="_times_jb">
                                <a href="{{route('jobs.by.sector', $job->jobSector->slug)}}">
                                {{ $job->jobSector->name }}
                                </a>
                            </div>

                            <div class="_jb_types fulltime_lite">
                                 <a href="{{route('jobs.by.type', $job->jobType->slug)}}">
                                {{ $job->jobType->name }}
                                </a>
                            </div>

                            <div class="_times_jb">
                                <i class="lni lni-map-marker me-1"></i>
                                 <a href="{{route('jobs.by.city', $job->city->slug)}}">
                                {{ $job->city->city_name }}
                                </a>
                            </div>

                        </div>
                    </div>

                    <div class="_jb_list72_foot">
                        <div class="_times_jb">
                            Closing:
                            {{ ($job->job_closing_date)->format('d/m/Y') }}
                        </div>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="bg-white rounded p-4 text-center">
                    No jobs found for these filters.
                </div>
            </div>
        @endforelse

    </div>

    {{-- ================= PAGINATION ================= --}}
    @if ($jobs->hasPages())
            <div class="col-lg-12 col-md-12 col-sm-12">
                <ul class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($jobs->onFirstPage())
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span class="fas fa-arrow-circle-right"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $jobs->previousPageUrl() }}" aria-label="Next">
                                <span class="fas fa-arrow-circle-right"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    @endif
                    {{-- Pagination Elements --}}
                    @if ($jobs->lastPage() > 1)
                        @for ($i = max(1, $jobs->currentPage() - 2); $i <= min($jobs->lastPage(), $jobs->currentPage() + 2); $i++)
                            <li class="page-item">
                                <a class="{{ $jobs->currentPage() == $i ? ' page-link page-link-active' : 'page-link' }}"
                                    href="{{ $jobs->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor
                    @endif

                    {{-- Next Page Link --}}
                    @if ($jobs->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $jobs->nextPageUrl() }}">Next</a></li>
                    @else
                        <li class="page-item disabled"><a class="page-link" href="{{ $jobs->nextPageUrl() }}">Last</a></li>
                    @endif
                </ul>
        @endif

</div>