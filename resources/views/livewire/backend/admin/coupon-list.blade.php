<div>
    {{-- Search and Filters Section --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                placeholder="Search coupons...">
        </div>
        <div class="col-md-2">
            <select wire:model.live="statusFilter" class="form-select">
                <option value="all">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
         <div class="col-md-3">
            <select wire:model.live="couponFilter" class="form-select">
                <option value="all">All Orders</option>
                <option value="with_orders">With Orders</option>
                <option value="without_orders">Without Orders</option>
            </select>
        </div>
        <div class="col-md-3">
            <button wire:click="resetFilters" class="btn btn-secondary btn-sm me-2">
                <i class="mdi mdi-refresh"></i> Reset
            </button>
            <a href="{{ route('admin.coupons.export', ['format' => 'excel', 'search' => $search, 'statusFilter' => $statusFilter, 'couponFilter' => $couponFilter]) }}"
                class="btn btn-success btn-sm me-1">
                <i class="mdi mdi-file-excel"></i> Excel
            </a>
            <a href="{{ route('admin.coupons.export', ['format' => 'pdf', 'search' => $search, 'statusFilter' => $statusFilter, 'couponFilter' => $couponFilter]) }}"
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
                        <th>Code</th>
                        <th>Type</th>
                        <th>Discount Value</th>
                        <th>Usage Limit</th>
                        <th>Minimum Purchase</th>
                        <th>Usage Counts</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Is Active?</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($coupons) > 0)
                        @foreach ($coupons as $key => $coupon)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $coupon->code }}</td>
                                <td>{{$coupon->type}}</td>
                                <td>{{$coupon->discount_value}}</td>
                                <td>{{$coupon->usage_limit}}</td>
                                <td>{{number_format($coupon->min_purchase)}}</td>
                                <td>{{$coupon->used_count}}</td>
                                <td>{{$coupon->start_date->format('d/m/Y')}}</td>
                                <td>{{$coupon->end_date->format('d/m/Y')}}</td>
                                <td>
                                     <button wire:click="toggleStatus({{ $coupon->id }})"
                                        class="btn btn-sm {{ $coupon->is_active ? 'btn-success' : 'btn-secondary' }}">
                                        {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </td> 

                                <td>
                                    @canany(['coupons.edit', 'coupons.manage'])
                                        <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    @endcanany
                                    @if($coupon->used_count === 0)
                                    @canany(['coupons.delete', 'coupons.manage'])
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $coupon->id }}"><i class="fas fa-trash"></i>
                                        </button>
                                        <div id="deleteModal{{ $coupon->id }}" class="modal fade" tabindex="-1"
                                            role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="{{ route('admin.coupons.destroy', $coupon->id) }}"
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
                                        @endif

                                    </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center"><span class="text-danger">Add New Coupon</span>
                                            <a href="{{ route('admin.coupons.create') }}">here</a>
                                        </td>
                                    </tr>
                                    @endif
                                    </tbody>
                                    </table>
                                                <div class="d-flex justify-content-end mt-3">
                                                    <nav aria-label="Page navigation example">
                                                        <ul class="pagination mb-0">
                                                            {{-- Previous Page Link --}}
                                                            @if ($coupons->onFirstPage())
                                                                <li class="page-item disabled">
                                                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                                                        &laquo; {{-- Left arrow --}}
                                                                    </a>
                                                                </li>
                                                            @else
                                                                <li class="page-item">
                                                                    <a class="page-link" href="{{ $coupons->previousPageUrl() }}">
                                                                        &laquo; {{-- Left arrow --}}
                                                                    </a>
                                                                </li>
                                                            @endif

                                                            {{-- Pagination Elements --}}
                                                            @foreach ($coupons->getUrlRange(1, $coupons->lastPage()) as $page => $url)
                                                                <li class="page-item {{ $coupons->currentPage() == $page ? 'active' : '' }}">
                                                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                                </li>
                                                            @endforeach

                                                            {{-- Next Page Link --}}
                                                            @if ($coupons->hasMorePages())
                                                                <li class="page-item">
                                                                    <a class="page-link" href="{{ $coupons->nextPageUrl() }}">
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
