<div>
    <div class="row">
    <div class="col-12">
        <!-- Summary Cards -->
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Total Payments</p>
                                <h4 class="mb-0">{{ $totalPayments }}</h4>
                            </div>
                            <div class="avatar-sm rounded-circle bg-primary align-self-center">
                                <span class="avatar-title rounded-circle bg-primary">
                                    <i class="bx bx-money font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Successful</p>
                                <h4 class="mb-0 text-success">{{ $currency }}  {{number_format($successfulAmount,2)}}  </h4>
                            </div>
                            <div class="avatar-sm rounded-circle bg-success align-self-center">
                                <span class="avatar-title rounded-circle bg-success">
                                    <i class="bx bx-check-circle font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Pending</p>
                                <h4 class="mb-0 text-warning">{{ $currency }}  {{ number_format($pendingAmount, 2) }}</h4>
                            </div>
                            <div class="avatar-sm rounded-circle bg-warning align-self-center">
                                <span class="avatar-title rounded-circle bg-warning">
                                    <i class="bx bx-time-five font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">Failed</p>
                                <h4 class="mb-0 text-danger">{{ $currency }} {{ number_format($failedAmount, 2) }}</h4>
                            </div>
                            <div class="avatar-sm rounded-circle bg-danger align-self-center">
                                <span class="avatar-title rounded-circle bg-danger">
                                    <i class="bx bx-error-circle font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                {{-- Filters --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <input type="text" wire:model.live.debounce.300ms="search" 
                            class="form-control" 
                            placeholder="Search ref, order, customer...">
                    </div>
                    <div class="col-md-2">
                        <select wire:model.live="paymentStatusFilter" class="form-select">
                            <option value="all">All Status</option>
                            <option value="Completed">Completed</option>
                            <option value="Pending">Pending</option>
                            <option value="Failed">Failed</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select wire:model.live="paymentMethodFilter" class="form-select">
                            <option value="all">All Methods</option>
                            <option value="Visa">Credit/Debit Card</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select wire:model.live="currencyFilter" class="form-select">
                            <option value="all">All Currencies</option>
                            <option value="TZS">TZS</option>
                            <option value="USD">USD</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select wire:model.live="amountRange" class="form-select">
                            <option value="all">All Amounts</option>
                            <option value="0-10000">0 - 1,0000</option>
                            <option value="10000-50000">10,000 - 50,000</option>
                            <option value="50000-100000">50,000 - 10,0000</option>
                            <option value="100000+">10,0000+</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button wire:click="resetFilters" class="btn btn-secondary w-100">
                            <i class="mdi mdi-refresh"></i>
                        </button>
                    </div>
                </div>

                <!-- Row 2: Date Filters and Export Buttons -->
                <div class="row g-3 align-items-end">
                    <div class="col-md-3 mb-3">
                        <input type="date" wire:model.live="from_date" 
                            class="form-control" placeholder="From Date">
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="date" wire:model.live="to_date" 
                            class="form-control" placeholder="To Date">
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="btn-group w-100" role="group">
                            <button wire:click="setQuickFilter(0)" type="button" 
                                class="btn btn-outline-primary">Today</button>
                            <button wire:click="setQuickFilter(7)" type="button" 
                                class="btn btn-outline-primary">7 Days</button>
                            <button wire:click="setQuickFilter(30)" type="button" 
                                class="btn btn-outline-primary">30 Days</button>
                            <button wire:click="setQuickFilter(90)" type="button" 
                                class="btn btn-outline-primary">90 Days</button>
                        </div>
                    </div>
                    <div class="col-md-2 text-md-end mb-3">
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.payments.export', [ 'format' => 'pdf', 'search' => $search, $paymentStatusFilter => 'paymentStatusFilter',
                                 $paymentMethodFilter => 'paymentMethodFilter', $amountRange => 'amountRange', $currencyFilter => 'currencyFilter']) }}" 
                                class="btn btn-danger btn-sm">
                                <i class="mdi mdi-file-pdf"></i> PDF
                            </a>
                            <a href="{{ route('admin.payments.export', [ 'format' => 'excel', 'search' => $search, $paymentStatusFilter => 'paymentStatusFilter',
                                 $paymentMethodFilter => 'paymentMethodFilter', $amountRange => 'amountRange', $currencyFilter => 'currencyFilter']) }}"  
                                class="btn btn-success btn-sm">
                                <i class="mdi mdi-file-excel"></i> Excel
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                   <table class="table table-bordered dt-responsive nowrap w-100">
                            <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Payment Ref</th>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th>Payment Account</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $payment)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $payment->payment_reference }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.index', $payment->order_id) }}" 
                                        class="text-primary">
                                        #{{ $payment->order->order_number}}
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ $payment->user->name }}</h6>
                                            <small class="text-muted">{{ $payment->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <strong>{{ $payment->currency }} {{ number_format($payment->amount, 2) }}</strong>
                                </td>
                                <td>
                                    @switch($payment->payment_method)
                                        @case('Visa')
                                            <span class="badge bg-success">
                                               <i class='bx bx-credit-card'></i> {{$payment->payment_method}}
                                            </span>
                                            @break
                                         @default
                                            <span class="badge bg-secondary">{{ ucfirst($payment->payment_method) }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    @switch($payment->payment_status)
                                        @case('Completed')
                                        @case('paid')
                                            <span class="badge bg-success">
                                                <i class="bx bx-check-circle"></i> Completed
                                            </span>
                                            @break
                                        @case('Pending')
                                            <span class="badge bg-warning">
                                                <i class="bx bx-time"></i> Pending
                                            </span>
                                            @break
                                        @case('Failed')
                                            <span class="badge bg-danger">
                                                <i class="bx bx-x-circle"></i> Failed
                                            </span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ ucfirst($payment->payment_status) }}</span>
                                    @endswitch
                                    @if($payment->status_code)
                                        <small class="text-muted d-block">Code: {{ $payment->status_code }}</small>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $payment->payment_account ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    <div>{{ $payment->created_at->format('d M Y') }}</div>
                                    <small class="text-muted">{{ $payment->created_at->format('h:i A') }}</small>
                                </td>
                                <td>
                                        <button type="button" class="btn btn-sm btn-primary" 
                                            wire:click="viewOrder(40)"
                                            title="View Details">
                                            <i class="mdi mdi-eye"></i>
                                        </button>
                                   
                                        <button type="button" class="btn btn-sm btn-success" 
                                            wire:click="generateReceipt({{ $payment->id }})"
                                            title="Download receipt">
                                            <i class="bx bx-download"></i>
                                        </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center py-5">
                                    <i class="bx bx-receipt font-size-48 text-muted"></i>
                                    <p class="text-muted mt-2">No payments found</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="4" class="text-end">Total (Filtered):</th>
                                <th colspan="7">
                                    {{-- <strong>{{ $currency }} {{ number_format($filteredTotal, 2) }}</strong> --}}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="d-flex justify-content-end mt-3">
                            <nav aria-label="Page navigation example">
                                <ul class="pagination mb-0">
                                    {{-- Previous Page Link --}}
                                    @if ($payments->onFirstPage())
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                                &laquo; {{-- Left arrow --}}
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $payments->previousPageUrl() }}">
                                                &laquo; {{-- Left arrow --}}
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($payments->getUrlRange(1, $payments->lastPage()) as $page => $url)
                                        <li class="page-item {{ $payments->currentPage() == $page ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($payments->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $payments->nextPageUrl() }}">
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

    {{-- Order Detail Modal --}}
    @if ($showDetailModal && $selectedPayment)
                <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Order Details - {{ $selectedPayment->order_number }}</h5>
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
                                                <td>{{ $selectedPayment->user->name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email:</strong></td>
                                                <td>{{ $selectedPayment->user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Phone:</strong></td>
                                                <td>{{ $selectedPayment->user->mobile_phone ?? 'N/A' }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                    {{-- Shipping Information --}}
                                    <div class="col-md-6">
                                        <h6 class="mb-3">Shipping Information</h6>
                                        <table class="table table-sm">
                                            <tr>
                                                <td><strong>Contact Person:</strong></td>
                                                <td>{{ $selectedPayment->shippingAddress->contact_person }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Mobile:</strong></td>
                                                <td>{{ $selectedPayment->shippingAddress->mobile_phone }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Region:</strong></td>
                                                <td>{{ $selectedPayment->shippingAddress->ward->district->region->name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>District:</strong></td>
                                                <td>{{ $selectedPayment->shippingAddress->ward->district->name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Ward:</strong></td>
                                                <td>{{ $selectedPayment->shippingAddress->ward->name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Street:</strong></td>
                                                <td>{{ $selectedPayment->shippingAddress->street_name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Postal Code:</strong></td>
                                                <td>{{ $selectedPayment->shippingAddress->postal_code }}</td>
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
                                            @foreach ($selectedPayment->orderItem as $item)
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
                                                    {{ number_format($selectedPayment->subtotal, 2) }}
                                                    TZS</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Shipping Cost:</strong></td>
                                                <td class="text-end">
                                                    {{ number_format($selectedPayment->shipping_cost, 2) }} TZS
                                                </td>
                                            </tr>
                                            @if ($selectedPayment->discount > 0)
                                                <tr>
                                                    <td><strong>Discount:</strong></td>
                                                    <td class="text-end text-success">
                                                        -{{ number_format($selectedPayment->discount, 2) }} TZS</td>
                                                </tr>
                                                @if ($selectedPayment->coupon_code)
                                                    <tr>
                                                        <td colspan="2" class="text-end">
                                                            <small class="text-muted">Coupon:
                                                                {{ $selectedPayment->coupon_code }}</small>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endif
                                            <tr class="table-active">
                                                <td><strong>Total:</strong></td>
                                                <td class="text-end">
                                                    <strong>{{ number_format($selectedPayment->total, 2) }}
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
                                                class="badge bg-{{ $selectedPayment->status === 'delivered' ? 'success' : ($selectedPayment->status === 'shipped' ? 'info' : ($selectedPayment->status === 'processing' ? 'warning' : 'secondary')) }}">
                                                {{ ucfirst($selectedPayment->status) }}
                                            </span>
                                        </p>
                                        <p><strong>Payment Status:</strong>
                                            <span
                                                class="badge bg-{{ $selectedPayment->payment_status === 'paid' ? 'success' : ($selectedPayment->payment_status === 'failed' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($selectedPayment->payment_status) }}
                                            </span>
                                        </p>
                                        @if ($selectedPayment->payment_method)
                                            <p><strong>Payment Method:</strong>
                                                {{ $selectedPayment->payment_method }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        @if ($selectedPayment->notes)
                                            <p><strong>Notes:</strong><br>{{ $selectedPayment->notes }}</p>
                                        @endif
                                        <p><strong>Order Date:</strong>
                                            {{ $selectedPayment->created_at->format('d M Y H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button wire:click="generateShippingLabel({{ $selectedPayment->id }})"
                                    class="btn btn-secondary btn-sm">
                                    <i class="mdi mdi-truck"></i> Shipping Label
                                </button>
                                <button wire:click="generateInvoice({{ $selectedPayment->id }})"
                                    class="btn btn-info btn-sm">
                                    <i class="mdi mdi-file-document"></i> Invoice
                                </button>
                                @if ($selectedPayment->payment_status === 'paid')
                                    <button wire:click="generateReceipt({{ $selectedPayment->id }})"
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
