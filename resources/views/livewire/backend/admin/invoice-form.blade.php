<div>
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-end pb-1">
                <a href="{{ route('admin.invoices.index') }}"
                    class="btn btn-primary btn-sm w-md waves-effect waves-light">
                    <i class="bx bx-list-ul"></i> All Invoices
                </a>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $invoice ? 'Edit Invoice' : 'New Invoice' }}</h4>
                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-12">
                            <form wire:submit.prevent="save">
                                <div class="row">
                                    <!-- Left Column -->
                                    <div class="col-lg-6">
                                        <!-- Invoice Number -->
                                        <div class="mb-3">
                                            <label for="invoice_number">Invoice Number <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" wire:model="invoice_number"
                                                class="form-control @error('invoice_number') is-invalid @enderror"
                                                required readonly>
                                            @error('invoice_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Invoice Date -->
                                        <div class="mb-3">
                                            <label for="invoice_date">Invoice Date <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" wire:model="invoice_date"
                                                class="form-control @error('invoice_date') is-invalid @enderror"
                                                required>
                                            @error('invoice_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Due Date -->
                                        <div class="mb-3">
                                            <label for="due_date">Due Date</label>
                                            <input type="date" wire:model="due_date"
                                                class="form-control @error('due_date') is-invalid @enderror">
                                            @error('due_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Right Column -->
                                    <div class="col-lg-6">
                                        <!-- From Address -->
                                        <div class="mb-3">
                                            <label for="from">From <span class="text-danger">*</span></label>
                                            <textarea wire:model="from" rows="4" class="form-control @error('from') is-invalid @enderror"
                                                placeholder="Your company details..." required></textarea>
                                            @error('from')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Billed To -->
                                        <div class="mb-3">
                                            <label for="billed_to">Billed To <span class="text-danger">*</span></label>
                                            <textarea wire:model="billed_to" rows="4" class="form-control @error('billed_to') is-invalid @enderror"
                                                placeholder="Client details..." required></textarea>
                                            @error('billed_to')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Invoice Items -->
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="mb-3">Invoice Items</h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th width="40%">Description</th>
                                                        <th width="15%">Quantity</th>
                                                        <th width="15%">Rate</th>
                                                        <th width="20%">Amount</th>
                                                        <th width="10%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($items as $index => $item)
                                                        <tr>
                                                            <td>
                                                                <textarea wire:model.lazy="items.{{ $index }}.description"
                                                                    class="form-control @error('items.' . $index . '.description') is-invalid @enderror" rows="2"
                                                                    placeholder="Item description..."></textarea>
                                                                @error('items.' . $index . '.description')
                                                                    <div class="text-danger small">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <input type="number"
                                                                    wire:model.lazy="items.{{ $index }}.quantity"
                                                                    class="form-control @error('items.' . $index . '.quantity') is-invalid @enderror"
                                                                    min="1" step="1">
                                                                @error('items.' . $index . '.quantity')
                                                                    <div class="text-danger small">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <input type="number"
                                                                    wire:model.lazy="items.{{ $index }}.rate"
                                                                    class="form-control @error('items.' . $index . '.rate') is-invalid @enderror"
                                                                    min="0" step="0.01">
                                                                @error('items.' . $index . '.rate')
                                                                    <div class="text-danger small">{{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </td>
                                                            <td>
                                                                <input type="text"
                                                                    value="{{ number_format($item['amount'], 2) }}"
                                                                    class="form-control" readonly>
                                                            </td>
                                                            <td>
                                                                <button type="button"
                                                                    wire:click="removeItem({{ $index }})"
                                                                    class="btn btn-danger btn-sm"
                                                                    {{ count($items) <= 1 ? 'disabled' : '' }}>
                                                                    <i class="bx bx-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="mb-3">
                                            <button type="button" wire:click="addItem"
                                                class="btn btn-success btn-sm">
                                                <i class="bx bx-plus"></i> Add Item
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Summary Section -->
                                <div class="row">
                                    <div class="col-lg-8">
                                        <!-- Notes -->
                                        <div class="mb-3">
                                            <label for="notes">Notes</label>
                                            <textarea wire:model="notes" rows="3" class="form-control" placeholder="Additional notes..."></textarea>
                                        </div>

                                        <!-- Terms -->
                                        <div class="mb-3">
                                            <label for="terms">Terms & Conditions</label>
                                            <textarea wire:model="terms" rows="3" class="form-control" placeholder="Payment terms and conditions..."></textarea>
                                        </div>
                                    </div>

                                    <!-- Totals -->
                                    <div class="col-lg-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="card-title">Invoice Summary</h6>

                                                <!-- Subtotal -->
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Subtotal:</span>
                                                    <span>${{ number_format($subtotal, 2) }}</span>
                                                </div>

                                                <!-- Discount -->
                                                <div class="row mb-2">
                                                    <div class="col-6">
                                                        <label class="form-label small">Discount %:</label>
                                                        <input type="number" wire:model.lazy="discount_rate"
                                                            class="form-control form-control-sm" min="0"
                                                            max="100" step="0.01">
                                                    </div>
                                                    <div class="col-6 d-flex align-items-end">
                                                        <span
                                                            class="text-danger">-${{ number_format($discount_amount, 2) }}</span>
                                                    </div>
                                                </div>

                                                <!-- Tax -->
                                                <div class="row mb-2">
                                                    <div class="col-6">
                                                        <label class="form-label small">Tax %:</label>
                                                        <input type="number" wire:model.lazy="tax_rate"
                                                            class="form-control form-control-sm" min="0"
                                                            max="100" step="0.01">
                                                    </div>
                                                    <div class="col-6 d-flex align-items-end">
                                                        <span
                                                            class="text-success">+${{ number_format($tax_amount, 2) }}</span>
                                                    </div>
                                                </div>

                                                <hr>

                                                <!-- Total -->
                                                <div class="d-flex justify-content-between mb-3">
                                                    <strong>Total:</strong>
                                                    <strong
                                                        class="text-primary">${{ number_format($total, 2) }}</strong>
                                                </div>

                                                <!-- Amount Paid -->
                                                <div class="mb-2">
                                                    <label class="form-label small">Amount Paid:</label>
                                                    <input type="number" wire:model.lazy="amount_paid"
                                                        class="form-control form-control-sm" min="0"
                                                        step="0.01">
                                                </div>

                                                <!-- Balance Due -->
                                                <div class="d-flex justify-content-between">
                                                    <strong>Balance Due:</strong>
                                                    <strong
                                                        class="{{ $total - $amount_paid > 0 ? 'text-danger' : 'text-success' }}">
                                                        ${{ number_format($total - $amount_paid, 2) }}
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Save Button -->
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('admin.invoices.index') }}"
                                                class="btn btn-secondary">Cancel</a>
                                            <button type="submit" class="btn btn-success"
                                                wire:loading.attr="disabled">
                                                <span wire:loading.remove>
                                                    <i class="bx bx-save"></i>
                                                    {{ $invoice ? 'Update Invoice' : 'Save Invoice' }}
                                                </span>
                                                <span wire:loading>
                                                    <i class="bx bx-loader-alt bx-spin"></i> Saving...
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> <!-- end row -->
                </div>
            </div>
        </div>
    </div>

</div>
</div>
