<div>
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center pb-3">
                <h4 class="mb-0">Invoice Management</h4>
                <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary btn-sm waves-effect waves-light">
                    <i class="bx bx-plus"></i> New Invoice
                </a>
            </div>

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
            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Search invoice number..."
                        wire:model.live.debounce.500ms="searchInvoice">
                </div>

                <div class="col-md-3">
                    <input type="date" class="form-control" wire:model.live="dateFilter"
                        placeholder="Filter by date">
                </div>

                <div class="col-md-3">
                    <button wire:click="clearFilters" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-times me-1"></i>
                        Clear Filters
                    </button>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Date</th>
                                    <th>Due Date</th>
                                    <th>Billed To</th>
                                    <th>Total</th>
                                    <th>Paid</th>
                                    <th>Balance</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $invoice)
                                    <tr>
                                        <td>
                                            <strong>{{ $invoice->invoice_number }}</strong>
                                        </td>
                                        <td>{{ $invoice->invoice_date->format('M d, Y') }}</td>
                                        <td>
                                            @if ($invoice->due_date)
                                                {{ $invoice->due_date->format('M d, Y') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 200px;"
                                                title="{{ strip_tags($invoice->billed_to) }}">
                                                {{ Str::limit(strip_tags($invoice->billed_to), 50) }}
                                            </div>
                                        </td>
                                        <td>${{ number_format($invoice->total, 2) }}</td>
                                        <td>${{ number_format($invoice->amount_paid, 2) }}</td>
                                        <td>
                                            <span
                                                class="{{ $invoice->balance_due > 0 ? 'text-danger' : 'text-success' }}">
                                                ${{ number_format($invoice->balance_due, 2) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('admin.invoices.show', $invoice) }}"
                                                    class="btn btn-info btn-sm" title="View">
                                                    <i class="bx bx-show"></i>
                                                </a>
                                                <a href="{{ route('admin.invoices.edit', $invoice) }}"
                                                    class="btn btn-primary btn-sm" title="Edit">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <a href="{{ route('admin.invoices.download', $invoice) }}"
                                                    class="btn btn-success btn-sm" title="Edit">
                                                    <i class="bx bxs-download"></i>
                                                </a>
                                                 <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $invoice->id }}"><i
                                                        class="bx bx-trash"></i> 
                                                    
                                                </button>
                                                 <div id="deleteModal{{ $invoice->id }}" class="modal fade" tabindex="-1"
                                                    role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form action="{{ route('admin.invoices.destroy', $invoice->id) }}"
                                                            method="post">@csrf
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="myModalLabel">Deletion
                                                                        Warning!</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>

                                                                @method('DELETE')
                                                                <div class="modal-body">
                                                                    <h4>Are you sure?</h4>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                        class="btn btn-secondary waves-effect"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit"
                                                                        class="btn btn-danger waves-effect waves-light">Yes,
                                                                        Delete</button>
                                                                </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="bx bx-receipt display-4 d-block mb-2"></i>
                                                No invoices found. <a
                                                    href="{{ route('admin.invoices.create') }}">Create your first
                                                    invoice</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-3">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination mb-0">
                                    {{-- Previous Page Link --}}
                                    @if ($invoices->onFirstPage())
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                                &laquo; {{-- Left arrow --}}
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $invoices->previousPageUrl() }}">
                                                &laquo; {{-- Left arrow --}}
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($invoices->getUrlRange(1, $invoices->lastPage()) as $page => $url)
                                        <li class="page-item {{ $invoices->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($invoices->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $invoices->nextPageUrl() }}">
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
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete invoice <strong id="invoiceNumber"></strong>?</p>
                    <p class="text-muted">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        <i class="fas fa-trash me-1"></i>
                        Delete Invoice
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
