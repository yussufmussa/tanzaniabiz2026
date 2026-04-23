<div>
    {{-- end filtering --}}
    <div class="col-12">
        <div class="d-flex justify-content-end pb-1">
            <a href="{{ route('events.create') }}" class="btn btn-primary btn-sm w-md waves-effect waves-light me-1">
                <i class="bx bx-plus"></i> Add New Event
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                {{-- Search and Filters Section --}}
                <div class="row mb-3">
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="search" wire:model.live.debounce.300ms="search"
                            placeholder="Search events...">
                    </div>
                    
                    <div class="col-md-3">
                        <button wire:click="clearFilters" class="btn btn-secondary btn-sm me-2">
                            <i class="mdi mdi-refresh"></i> Reset
                        </button>
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
                                <th>Banner</th>
                                <th>Title</th>
                                <th>Location</th>
                                <th>Start</th>
                                <th>Close</th>
                                <th width="140">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($events as $event)
                                <tr>
                                    <td>
                                        <img
                                            src="{{ $event->thumbnail ? asset('uploads/businessEvents/thumbnails/'.$event->thumbnail) : asset('uploads/general/event_placeholder.png') }}"
                                            width="60" height="60" class="rounded" alt="banner">
                                    </td>
                                    <td>{{ $event->title }}</td>
                                    <td>{{ $event->event_loction }}</td>
                                    <td><span class="badge border border-primary text-primary">{{ $event->starting_date->format('d/m/Y') }}</span> <span class="badge bg-success">{{ $event->starting_time->format('H:m') }}</span></td>
                                    <td><span class="badge border border-primary text-primary">{{ $event->closing_date->format('d/m/Y') }}</span> <span class="badge bg-warning">{{ $event->ending_time->format('H:m') }}</span></td>
                                    <td>
                                         <a href="{{ route('event.detail', $event->slug) }}" target="_blank" class="btn btn-sm btn-success">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-pen"></i>
                                        </a>

                                        <form action="{{ route('events.destroy', $event) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete this event?')">
                                            <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No events found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                        <div class="d-flex justify-content-end mt-3">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination mb-0">
                                    {{-- Previous Page Link --}}
                                    @if ($events->onFirstPage())
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                                &laquo; {{-- Left arrow --}}
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $events->previousPageUrl() }}">
                                                &laquo; {{-- Left arrow --}}
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($events->getUrlRange(1, $events->lastPage()) as $page => $url)
                                        <li class="page-item {{ $events->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($events->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $events->nextPageUrl() }}">
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
