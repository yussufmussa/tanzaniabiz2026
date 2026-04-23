<div>
    {{-- end filtering --}}
    <div class="col-12">
        <div class="d-flex justify-content-end pb-1">
            <a href="{{ route('jobs.create') }}" class="btn btn-primary btn-sm w-md waves-effect waves-light me-1">
                <i class="bx bx-plus"></i> Add New Job Post
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                {{-- Search and Filters Section --}}
                <div class="row mb-3">
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="search" wire:model.live.debounce.300ms="search"
                            placeholder="Search jobs...">
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" id="sector" wire:model.live="jobSectorFilter">
                            <option value="">All Sectors</option>
                            @foreach ($jobSectors as $sector)
                                <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select class="form-select" id="type" wire:model.live="jobTypeFilter">
                            <option value="">All Types</option>
                            @foreach ($jobTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select class="form-select" id="city" wire:model.live="cityFilter">
                            <option value="">All Cities</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->city_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button wire:click="clearFilters" class="btn btn-secondary btn-sm me-2">
                            <i class="mdi mdi-refresh"></i> Reset
                        </button>
                        <a href="{{ route('listings.export', ['format' => 'excel', 'search' => $search, 'jobSectorFilter' => $jobSectorFilter, 'cityFilter' => $cityFilter, 'jobTypeFilter' => $jobTypeFilter]) }}"
                            class="btn btn-success btn-sm me-1">
                            <i class="mdi mdi-file-excel"></i> Excel
                        </a>
                        <a href="{{ route('listings.export', ['format' => 'pdf', 'search' => $search, 'jobSectorFilter' => $jobSectorFilter, 'cityFilter' => $cityFilter, 'jobTypeFilter' => $jobTypeFilter]) }}"
                            class="btn btn-danger btn-sm">
                            <i class="mdi mdi-file-pdf"></i> PDF
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Sector</th>
                                    <th>Type</th>
                                    <th>City</th>
                                    <th>Opening</th>
                                    <th>Closing</th>
                                    <th width="140">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jobs as $job)
                                    <tr>
                                        <td>{{ $job->title }}</td>
                                        <td>{{ $job->jobSector?->name }}</td>
                                        <td>{{ $job->jobType?->name }}</td>
                                        <td>{{ $job->city?->city_name }}</td>
                                        <td>{{ $job->job_opening_date->format('m/d/Y H:m:s') }}</td>
                                        <td>{{ $job->job_closing_date->format('m/d/Y H:m:s') }}</td>
                                        <td>
                                             <a href="{{ route('job.detail', $job->slug) }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('jobs.edit', $job) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            
                                            <form action="{{ route('jobs.destroy', $job) }}" method="post"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Delete this job?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No jobs found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-3">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination mb-0">
                                    {{-- Previous Page Link --}}
                                    @if ($jobs->onFirstPage())
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                                &laquo; {{-- Left arrow --}}
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $jobs->previousPageUrl() }}">
                                                &laquo; {{-- Left arrow --}}
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($jobs->getUrlRange(1, $jobs->lastPage()) as $page => $url)
                                        <li class="page-item {{ $jobs->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($jobs->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $jobs->nextPageUrl() }}">
                                                &raquo; {{-- Right arrow --}}
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                                &raquo; {{-- Right arrow --}}
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Delete Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete "<span id="listing-name"></span>"?</p>
                            <p class="text-danger small">This action cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <form id="delete-form" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.delete-listing').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.id;
            const productName = this.dataset.name;

            document.getElementById('listing-name').textContent = productName;
            document.getElementById('delete-form').action = `/listings/${productId}`;

            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });

    // Helper function to show alerts
    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>`;

        const container = document.querySelector('.container-fluid');
        const existingAlert = container.querySelector('.alert');

        if (existingAlert) {
            existingAlert.remove();
        }

        container.insertAdjacentHTML('afterbegin', alertHtml);

        // Auto-hide after 3 seconds
        setTimeout(() => {
            const alert = container.querySelector('.alert');
            if (alert) {
                new bootstrap.Alert(alert).close();
            }
        }, 3000);
    }

    // Auto-hide existing alerts
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
</script>
</div>
