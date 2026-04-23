<div>
    {{-- end filtering --}}
    <div class="col-12">
        <div class="d-flex justify-content-end pb-1">
            <a href="{{ route('listings.create') }}"
                class="btn btn-primary btn-sm w-md waves-effect waves-light me-1">
                <i class="bx bx-plus"></i> Add New Business
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                {{-- Search and Filters Section --}}
                <div class="row mb-3">
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="search" wire:model.live.debounce.300ms="search"
                            placeholder="Search businessess...">
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" id="category" wire:model.live="categoryFilter">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
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

                    <div class="col-md-2">
                        <select class="form-select" wire:model.live="statusFilter">
                            <option value="">All </option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button wire:click="clearFilters" class="btn btn-secondary btn-sm me-2">
                            <i class="mdi mdi-refresh"></i> Reset
                        </button>
                        <a href="{{ route('listings.export', ['format' => 'excel', 'search' => $search, 'statusFilter' => $statusFilter, 'cityFilter' => $cityFilter, 'categoryFilter' => $categoryFilter]) }}"
                            class="btn btn-success btn-sm me-1">
                            <i class="mdi mdi-file-excel"></i> Excel
                        </a>
                        <a href="{{ route('listings.export', ['format' => 'pdf', 'search' => $search, 'statusFilter' => $statusFilter, 'cityFilter' => $cityFilter, 'categoryFilter' => $categoryFilter]) }}"
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

                        @if ($listings->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Logo</th>
                                            <th>Business Name</th>
                                            <th>City</th>
                                            <th>Category</th>
                                            <th>Created At</th>
                                            <th>Uproved At</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listings as $listing)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                             <td>
                                            <img src="{{asset(asset('uploads/businessListings/logos/'.$listing->logo))}}" width="100px" height="100" class="avatar">
                                             </td>
                                                <td>
                                                    {{ $listing->name }}</strong>
                                                </td>
                                                <td>{{$listing->city->city_name}}</td>
                                                <td>{{$listing->category->name}}</td>
                                                <td>{{$listing->created_at->format('d-m-Y')}}</td>
                                                <td>{{$listing->updated_at->format('d-m-Y H:m:i')}}</td>
                                                <td>
                                                    <button wire:click="toggleStatus({{ $listing->id }})"
                                                        class="btn btn-sm ms-2 {{ $listing->status ? 'btn-success text-white' : 'btn-danger text-white' }}">
                                                        {{ $listing->status ? 'Active' : 'Pending' }}
                                                    </button>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                       @if ($listing->status)
                                                            <a href="{{ route('listing.details', ['listingSlug' => $listing->slug]) }}"
                                                            class="btn btn-sm btn-info" title="View" target="_blank">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                       @endif
                                                        @canany(['update.business_listings', 'manage.business_listings'])
                                                            <a href="{{ route('listings.edit', $listing) }}"
                                                                class="btn btn-sm btn-primary" title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        @endcanany
                                                        @canany(['delete.business_listings', 'manage.business_listings'])
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger delete-listing"
                                                                data-id="{{ $listing->id }}"
                                                                data-name="{{ $listing->name }}" title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        @endcanany
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end mt-3">
                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination mb-0">
                                            {{-- Previous Page Link --}}
                                            @if ($listings->onFirstPage())
                                                <li class="page-item disabled">
                                                    <a class="page-link" href="#" tabindex="-1"
                                                        aria-disabled="true">
                                                        &laquo; {{-- Left arrow --}}
                                                    </a>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $listings->previousPageUrl() }}">
                                                        &laquo; {{-- Left arrow --}}
                                                    </a>
                                                </li>
                                            @endif

                                            {{-- Pagination Elements --}}
                                            @foreach ($listings->getUrlRange(1, $listings->lastPage()) as $page => $url)
                                                <li
                                                    class="page-item {{ $listings->currentPage() == $page ? 'active' : '' }}">
                                                    <a class="page-link"
                                                        href="{{ $url }}">{{ $page }}</a>
                                                </li>
                                            @endforeach

                                            {{-- Next Page Link --}}
                                            @if ($listings->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $listings->nextPageUrl() }}">
                                                        &raquo; {{-- Right arrow --}}
                                                    </a>
                                                </li>
                                            @else
                                                <li class="page-item disabled">
                                                    <a class="page-link" href="#" tabindex="-1"
                                                        aria-disabled="true">
                                                        &raquo; {{-- Right arrow --}}
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No listing found</h5>
                                <p class="text-muted">Add New Listing.</p>
                                <a href="{{ route('listings.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Business Listing
                                </a>
                            </div>
                        @endif
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
