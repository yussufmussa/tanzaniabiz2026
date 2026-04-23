<div>
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center pb-3">
                <h4 class="mb-0">Order Managemant</h4>
                <a href="{{ route('admin.orders.create') }}" class="btn btn-primary btn-sm waves-effect waves-light">
                    <i class="bx bx-plus"></i> New Invoice
                </a>
            </div>
           
            <div class="card">
                <div class="card-body">
                    {{-- Filters --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                                placeholder="Search orders, customer...">
                        </div>
                        <div class="col-md-3">
                            <select wire:model.live="statusFilter" class="form-select">
                                <option value="all">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select wire:model.live="paymentStatusFilter" class="form-select">
                                <option value="all">Payment Status</option>
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                                <option value="failed">Failed</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button wire:click="resetFilters" class="btn btn-secondary w-100">
                                <i class="mdi mdi-refresh"></i> Reset
                            </button>
                        </div>
                    </div>

                    <!-- Row 2: Date Filters and Export Buttons -->
                    <div class="row g-3 align-items-end">
                        <!-- Date Range Pickers -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label visually-hidden">From Date</label>
                            <input type="date" wire:model.live="from_date" class="form-control"
                                placeholder="From Date">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label visually-hidden">To Date</label>
                            <input type="date" wire:model.live="to_date" class="form-control" placeholder="To Date">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label visually-hidden">Quick Date Filters</label>
                            <div class="btn-group w-100" role="group">
                                <button wire:click="setQuickFilter(0)" type="button"
                                    class="btn btn-outline-primary">Today</button>
                                <button wire:click="setQuickFilter(7)" type="button" class="btn btn-outline-primary">7
                                    Days</button>
                                <button wire:click="setQuickFilter(30)" type="button"
                                    class="btn btn-outline-primary">30 Days</button>
                                <button wire:click="setQuickFilter(90)" type="button"
                                    class="btn btn-outline-primary">90 Days</button>
                            </div>
                        </div>

                        <!-- Export Buttons -->
                        <div class="col-md-2 text-md-end mb-3">
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.orders.export', ['format' => 'pdf', 'search' => $search, 'statusFilter' => $statusFilter, 'paymentStatusFilter' => $paymentStatusFilter,
                                 'from_date' => $from_date, 'to_date' => $to_date]) }}"
                                    class="btn btn-danger btn-sm" title="Export Pdf">
                                    <i class="mdi mdi-file-pdf"></i>
                                    Pdf
                                </a>
                                <a href="{{ route('admin.orders.export', ['format' => 'excel', 'search' => $search, 'statusFilter' => $statusFilter, 'paymentStatusFilter' => $paymentStatusFilter,
                                'from_date' => $from_date, 'to_date' => $to_date]) }}"
                                    class="btn btn-success btn-sm" title="Export Excel">
                                    <i class="mdi mdi-file-excel"></i>
                                    Excel
                                </a>
                            </div>
                        </div>
                    </div>
                    {{-- end filtering --}}
                    <div class="table-responsive">
                        <table class="table table-bordered dt-responsive nowrap w-100">
                            <thead class="table-light">
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>{{ $order->order_number }}</td>
                                        <td>
                                            {{ $order->user->name }}<br>
                                            <small class="text-muted">{{ $order->user->email }}</small>
                                        </td>
                                        <td>{{ $order->created_at->format('d M Y') }}<br>
                                            <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                        </td>
                                        <td>{{ $order->orderItem->count() }} item(s)</td>
                                        <td>
                                            <strong>{{ number_format($order->total, 2) }} TZS</strong><br>
                                            @if ($order->discount > 0)
                                                <small class="text-success">Discount:
                                                    -{{ number_format($order->discount, 2) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($editingOrderId === $order->id)
                                                <select wire:model="status" class="form-select form-select-sm">
                                                    <option value="pending">Pending</option>
                                                    <option value="processing">Processing</option>
                                                    <option value="shipped">Shipped</option>
                                                    <option value="delivered">Delivered</option>
                                                </select>
                                            @else
                                                <span
                                                    class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'shipped' ? 'info' : ($order->status === 'processing' ? 'warning' : 'secondary')) }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($editingOrderId === $order->id)
                                                <select wire:model="payment_status" class="form-select form-select-sm">
                                                    <option value="pending">Pending</option>
                                                    <option value="paid">Paid</option>
                                                    <option value="failed">Failed</option>
                                                </select>
                                            @else
                                                <span
                                                    class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : ($order->payment_status === 'failed' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($order->payment_status) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($editingOrderId === $order->id)
                                                <button wire:click="updateOrder" class="btn btn-success btn-sm"
                                                    title="Save">
                                                    <i class="mdi mdi-check"></i>
                                                </button>
                                                <button wire:click="cancelEdit" class="btn btn-secondary btn-sm"
                                                    title="Cancel">
                                                    <i class="mdi mdi-close"></i>
                                                </button>
                                            @else
                                                <button wire:click="viewOrder({{ $order->id }})"
                                                    class="btn btn-info btn-sm" title="View Details">
                                                    <i class="mdi mdi-eye"></i>
                                                </button>
                                                <button wire:click="editOrder({{ $order->id }})"
                                                    class="btn btn-primary btn-sm" title="Edit">
                                                    <i class="mdi mdi-pencil"></i>
                                                </button>
                                                <div class="btn-group btn-sm" role="group">
                                                    <button type="button"
                                                        class="btn btn-secondary btn-sm dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="mdi mdi-printer"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="#"
                                                                wire:click.prevent="generateShippingLabel({{ $order->id }})">
                                                                <i class="mdi mdi-truck"></i> Shipping Label
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#"
                                                                wire:click.prevent="generateInvoice({{ $order->id }})">
                                                                <i class="mdi mdi-file-document"></i> Invoice
                                                            </a>
                                                        </li>
                                                        @if ($order->payment_status === 'paid')
                                                            <li>
                                                                <a class="dropdown-item" href="#"
                                                                    wire:click.prevent="generateReceipt({{ $order->id }})">
                                                                    <i class="mdi mdi-receipt"></i> Receipt
                                                                </a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                                <button wire:click="deleteOrder({{ $order->id }})"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this order?')"
                                                    title="Delete">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-3">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination mb-0">
                                    {{-- Previous Page Link --}}
                                    @if ($orders->onFirstPage())
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                                &laquo; {{-- Left arrow --}}
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $orders->previousPageUrl() }}">
                                                &laquo; {{-- Left arrow --}}
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                                        <li class="page-item {{ $orders->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($orders->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $orders->nextPageUrl() }}">
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


            {{-- Order Detail Modal --}}
            @if ($showDetailModal && $selectedOrder)
                <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Order Details - {{ $selectedOrder->order_number }}</h5>
                                <button type="button" class="btn-close" wire:click="closeDetailModal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    {{-- Customer Information --}}
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Customer Information</h6>
                                        <table class="table table-sm">
                                            <tr>
                                                <td><strong>Name:</strong></td>
                                                <td>{{ $selectedOrder->user->name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email:</strong></td>
                                                <td>{{ $selectedOrder->user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Phone:</strong></td>
                                                <td>{{ $selectedOrder->user->mobile_phone ?? 'N/A' }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                    {{-- Shipping Information --}}
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Shipping Information</h6>
                                        <table class="table table-sm">
                                            <tr>
                                                <td><strong>Contact Person:</strong></td>
                                                <td>{{ $selectedOrder->shippingAddress->contact_person }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Mobile:</strong></td>
                                                <td>{{ $selectedOrder->shippingAddress->mobile_phone }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Region:</strong></td>
                                                <td>{{ $selectedOrder->shippingAddress->ward->district->region->name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>District:</strong></td>
                                                <td>{{ $selectedOrder->shippingAddress->ward->district->name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Ward:</strong></td>
                                                <td>{{ $selectedOrder->shippingAddress->ward->name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Street:</strong></td>
                                                <td>{{ $selectedOrder->shippingAddress->street_name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Postal Code:</strong></td>
                                                <td>{{ $selectedOrder->shippingAddress->postal_code }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <hr>

                                {{-- Order Items --}}
                                <h6 class="mb-3">Order Items</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Product</th>
                                                <th>Unit Price</th>
                                                <th>Quantity</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($selectedOrder->orderItem as $item)
                                                <tr>
                                                    <td>{{ $item->product->title }}</td>
                                                    <td>{{ number_format($item->unit_price, 2) }} TZS</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>{{ number_format($item->subtotal, 2) }} TZS</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <hr>

                                {{-- Order Summary --}}
                                <div class="row">
                                    <div class="col-md-6 offset-md-6">
                                        <table class="table table-sm">
                                            <tr>
                                                <td><strong>Subtotal:</strong></td>
                                                <td class="text-end">
                                                    {{ number_format($selectedOrder->subtotal, 2) }}
                                                    TZS</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Shipping Cost:</strong></td>
                                                <td class="text-end">
                                                    {{ number_format($selectedOrder->shipping_cost, 2) }} TZS
                                                </td>
                                            </tr>
                                            @if ($selectedOrder->discount > 0)
                                                <tr>
                                                    <td><strong>Discount:</strong></td>
                                                    <td class="text-end text-success">
                                                        -{{ number_format($selectedOrder->discount, 2) }} TZS</td>
                                                </tr>
                                                @if ($selectedOrder->coupon_code)
                                                    <tr>
                                                        <td colspan="2" class="text-end">
                                                            <small class="text-muted">Coupon:
                                                                {{ $selectedOrder->coupon_code }}</small>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            <tr class="table-active">
                                                <td><strong>Total:</strong></td>
                                                <td class="text-end">
                                                    <strong>{{ number_format($selectedOrder->total, 2) }}
                                                        TZS</strong>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                {{-- Order Status & Payment --}}
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Order Status:</strong>
                                            <span
                                                class="badge bg-{{ $selectedOrder->status === 'delivered' ? 'success' : ($selectedOrder->status === 'shipped' ? 'info' : ($selectedOrder->status === 'processing' ? 'warning' : 'secondary')) }}">
                                                {{ ucfirst($selectedOrder->status) }}
                                            </span>
                                        </p>
                                        <p><strong>Payment Status:</strong>
                                            <span
                                                class="badge bg-{{ $selectedOrder->payment_status === 'paid' ? 'success' : ($selectedOrder->payment_status === 'failed' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($selectedOrder->payment_status) }}
                                            </span>
                                        </p>
                                        @if ($selectedOrder->payment_method)
                                            <p><strong>Payment Method:</strong>
                                                {{ $selectedOrder->payment_method }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        @if ($selectedOrder->notes)
                                            <p><strong>Notes:</strong><br>{{ $selectedOrder->notes }}</p>
                                        @endif
                                        <p><strong>Order Date:</strong>
                                            {{ $selectedOrder->created_at->format('d M Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button wire:click="generateShippingLabel({{ $selectedOrder->id }})"
                                    class="btn btn-secondary btn-sm">
                                    <i class="mdi mdi-truck"></i> Shipping Label
                                </button>
                                <button wire:click="generateInvoice({{ $selectedOrder->id }})"
                                    class="btn btn-info btn-sm">
                                    <i class="mdi mdi-file-document"></i> Invoice
                                </button>
                                @if ($selectedOrder->payment_status === 'paid')
                                    <button wire:click="generateReceipt({{ $selectedOrder->id }})"
                                        class="btn btn-success btn-sm">
                                        <i class="mdi mdi-receipt"></i> Receipt
                                    </button>
                                @endif
                                <button type="button" class="btn btn-secondary"
                                    wire:click="closeDetailModal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-backdrop fade show"></div>
            @endif
        </div>
    </div>
</div>
