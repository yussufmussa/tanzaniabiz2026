<div>
    {{-- Search and Filters Section --}}
    <div class="row mb-3">
        <div class="col-md-4 mb-2">
            <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                placeholder="Search brands...">
        </div>
        <div class="col-md-2 mb-2">
            <select wire:model.live="statusFilter" class="form-control">
                <option value="all">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <div class="col-md-3">
            <select wire:model.live="productFilter" class="form-control">
                <option value="all">All Brands</option>
                <option value="with_products">With Products</option>
                <option value="without_products">Without Products</option>
            </select>
        </div>
        <div class="col-md-3">
            <button wire:click="resetFilters" class="btn btn-secondary btn-sm me-2">
                <i class="mdi mdi-refresh"></i> Reset
            </button>
            <a href="{{ route('admin.brands.export', ['format' => 'excel', 'search' => $search, 'statusFilter' => $statusFilter, 'productFilter' => $productFilter]) }}"
                class="btn btn-success btn-sm me-1">
                <i class="mdi mdi-file-excel"></i> Excel
            </a>
            <a href="{{ route('admin.brands.export', ['format' => 'pdf', 'search' => $search, 'statusFilter' => $statusFilter, 'productFilter' => $productFilter]) }}"
                class="btn btn-danger btn-sm">
                <i class="mdi mdi-file-pdf"></i> PDF
            </a>
        </div>
    </div>
    {{-- end filtering --}}
    <div class="row">
        <div class="table-responsive">
            <table id="typeDT" class="table table-bordered  dt-responsive nowrap w-100">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>No. of Product(s)</th>
                        <th>Is Active?</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($brands) > 0)
                        @foreach ($brands as $key => $brand)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <img src="{{ $brand->photo_url }}" class="avatar" loading="lazy" decoding="async"
                                        alt="{{ $brand->name }}">
                                </td>
                                <td>{{ $brand->name }}</td>
                                <td>{{ $brand->products_count }}</td>
                                <td>
                                    <button wire:click="toggleStatus({{ $brand->id }})"
                                        class="btn btn-sm {{ $brand->is_active ? 'btn-success' : 'btn-secondary' }}">
                                        {{ $brand->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </td>
                                <td>
                                    @canany(['brands.edit', 'brands.manage'])
                                        <a href="{{ route('admin.brands.edit', $brand->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    @endcanany
                                    @canany(['brands.delete', 'brands.manage'])
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $brand->id }}"><i class="fas fa-trash"></i>
                                        </button>
                                        <div id="deleteModal{{ $brand->id }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="{{ route('admin.brands.destroy', $brand->id) }}"
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
            <td colspan="4" class="text-center">
                <span class="text-danger">Add New Brand</span>
                <a href="{{ route('admin.brands.create') }}">here</a>
            </td>
        </tr>
        @endif
        </tbody>
        </table>
                <div class="d-flex justify-content-end mt-3">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination mb-0">
                            {{-- Previous Page Link --}}
                            @if ($brands->onFirstPage())
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                        &laquo; {{-- Left arrow --}}
                                    </a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $brands->previousPageUrl() }}">
                                        &laquo; {{-- Left arrow --}}
                                    </a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($brands->getUrlRange(1, $brands->lastPage()) as $page => $url)
                                <li class="page-item {{ $brands->currentPage() == $page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($brands->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $brands->nextPageUrl() }}">
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
