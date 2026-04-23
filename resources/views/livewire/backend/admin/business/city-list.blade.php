<div>
    {{-- Search and Filters Section --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                placeholder="Search cities...">
        </div>
        <div class="col-md-2">
            <select wire:model.live="statusFilter" class="form-select">
                <option value="all">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <div class="col-md-3">
            <select wire:model.live="businessListing" class="form-select">
                <option value="all">All</option>
                <option value="with_business_listings">With Business Listings</option>
                <option value="without_business_listings">Without Business Listings</option>
            </select>
        </div>
        <div class="col-md-3">
            <button wire:click="resetFilters" class="btn btn-secondary btn-sm me-2">
                <i class="mdi mdi-refresh"></i> Reset
            </button>
        </div>
    </div>
    {{-- end filtering --}}
    <div class="row">
        <div class="table-responsive">
            <table id="typeDT" class="table table-bordered  dt-responsive nowrap w-100">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>No. of Business Listing(s)</th>
                        <th>Is Active?</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($cities) > 0)
                        @foreach ($cities as $key => $city)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $city->city_name }}</td>
                                <td>{{ $city->business_listing_count }}</td>
                                <td>
                                    <button wire:click="toggleStatus({{ $city->id }})"
                                        class="btn btn-sm {{ $city->is_active ? 'btn-success' : 'btn-secondary' }}">
                                        {{ $city->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </td>
                                <td>
                                    @canany(['update.cities', 'update.cities'])
                                        <a href="{{ route('cities.edit', $city->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    @endcanany
                                    @canany(['delete.cities', 'manage.cities'])
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $city->id }}"><i class="fas fa-trash"></i>
                                        </button>
                                        <div id="deleteModal{{ $city->id }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="{{ route('cities.destroy', $city->id) }}"
                                                    method="post">@csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel">Deletion
                                                                Warning!</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>

                                                        @method('DELETE')
                                                        <div class="modal-body">
                                                            <h4>Are you sure??</h4>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary waves-effect"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit"
                                                                class="btn btn-danger waves-effect waves-light">Yes,
                                                                Delete</button>
                                                        </div>
                                                </form>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        @endcanany


        </td>
        </tr>
        @endforeach
    @else
        <tr>
            <td colspan="4" class="text-center"><span class="text-danger">Add New City</span>
                <a href="{{ route('cities.create') }}">here</a>
            </td>
        </tr>
        @endif
        </tbody>
        </table>
        <div class="d-flex justify-content-end mt-3">
            <nav aria-label="Page navigation example">
                <ul class="pagination mb-0">
                    {{-- Previous Page Link --}}
                    @if ($cities->onFirstPage())
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                &laquo; {{-- Left arrow --}}
                            </a>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $cities->previousPageUrl() }}">
                                &laquo; {{-- Left arrow --}}
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($cities->getUrlRange(1, $cities->lastPage()) as $page => $url)
                        <li class="page-item {{ $cities->currentPage() == $page ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($cities->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $cities->nextPageUrl() }}">
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

<script>
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
</script>
</div>
