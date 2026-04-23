@section('contents')
<div>
  <div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 mb-1">Invoice Generator</h1>
            <div class="text-muted small">Invoices are saved on your device (local storage).</div>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-secondary" href="{{ route('tools.history') }}">History</a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            {{-- Top row: Logo area (left) + Invoice meta (right) --}}
            <div class="row g-3 align-items-start">
                <div class="col-lg-6">
                    <div class="border rounded p-4 text-center text-muted" style="min-height: 140px;">
                        <div class="fs-5">+ Add Your Logo</div>
                        <div class="small">(optional later)</div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label mb-1">From</label>
                        <textarea class="form-control" rows="3"
                                  placeholder="Business name&#10;Phone&#10;Email&#10;Address&#10;TIN/VRN (optional)"
                                  wire:model.blur="from_text"></textarea>
                        @error('from_text') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="d-flex justify-content-end">
                        <div class="text-end">
                            <div class="display-6 fw-light">INVOICE</div>
                        </div>
                    </div>

                    <div class="row g-2 mt-2">
                        <div class="col-6">
                            <label class="form-label mb-1">Invoice #</label>
                            <input class="form-control" placeholder="INV-0001" wire:model.blur="invoice.number">
                            @error('invoice.number') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-6">
                            <label class="form-label mb-1">Currency</label>
                            <select class="form-select" wire:model.live="currency">
                                <option value="TZS">TZS</option>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                            </select>
                            @error('currency') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-6">
                            <label class="form-label mb-1">Date</label>
                            <input type="date" class="form-control" wire:model.blur="invoice.date">
                            @error('invoice.date') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-6">
                            <label class="form-label mb-1">Payment Terms</label>
                            <input class="form-control" placeholder="e.g. Pay within 7 days"
                                   wire:model.blur="invoice.payment_terms">
                            @error('invoice.payment_terms') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-6">
                            <label class="form-label mb-1">Due Date</label>
                            <input type="date" class="form-control" wire:model.blur="invoice.due_date">
                            @error('invoice.due_date') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-6">
                            <label class="form-label mb-1">PO Number</label>
                            <input class="form-control" placeholder="optional" wire:model.blur="invoice.po_number">
                            @error('invoice.po_number') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bill To + Ship To --}}
            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <label class="form-label mb-1">Bill To</label>
                    <textarea class="form-control" rows="3"
                              placeholder="Customer name&#10;Phone&#10;Email&#10;Address"
                              wire:model.blur="bill_to_text"></textarea>
                    @error('bill_to_text') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label mb-1">Ship To <span class="text-muted">(optional)</span></label>
                    <textarea class="form-control" rows="3"
                              placeholder="Shipping address / receiver details"
                              wire:model.blur="ship_to_text"></textarea>
                    @error('ship_to_text') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Items --}}
            <div class="mt-4">
                <div class="bg-dark text-white rounded px-3 py-2 d-flex">
                    <div class="flex-grow-1">Item</div>
                    <div style="width:120px;">Quantity</div>
                    <div style="width:140px;">Rate</div>
                    <div style="width:140px;" class="text-end">Amount</div>
                </div>

                <div class="mt-2">
                    @foreach($items as $i => $item)
                        <div class="row g-2 align-items-start mb-2">
                            <div class="col-lg-7">
                                <input class="form-control"
                                       placeholder="Description"
                                       wire:model.blur="items.{{ $i }}.description">
                                @error("items.$i.description") <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-4 col-lg-2">
                                <input type="number" min="0" step="0.01"
                                       class="form-control"
                                       wire:model.blur="items.{{ $i }}.qty">
                                @error("items.$i.qty") <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-4 col-lg-2">
                                <input type="number" min="0" step="0.01"
                                       class="form-control"
                                       wire:model.blur="items.{{ $i }}.unit_price">
                                @error("items.$i.unit_price") <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-4 col-lg-1 text-end">
                                @php
                                    $q = (float)($item['qty'] ?? 0);
                                    $p = (float)($item['unit_price'] ?? 0);
                                    $amt = max(0, $q * $p);
                                @endphp
                                <div class="pt-2 fw-semibold">{{ number_format($amt, 2) }}</div>
                                <button class="btn btn-sm btn-outline-danger mt-1" type="button"
                                        wire:click="removeItem({{ $i }})">×</button>
                            </div>
                        </div>
                    @endforeach

                    <button class="btn btn-outline-success" type="button" wire:click="addItem">
                        + Line Item
                    </button>
                </div>
            </div>

            {{-- Bottom: Payment details + Terms (left) and totals (right) --}}
            <div class="row g-4 mt-4">
                <div class="col-lg-7">
                    <div class="mb-3">
                        <label class="form-label mb-1">Payment Details</label>
                        <textarea class="form-control" rows="3"
                                  placeholder="Bank name, account number, mobile money, etc."
                                  wire:model.blur="payment_details"></textarea>
                        @error('payment_details') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="form-label mb-1">Terms</label>
                        <textarea class="form-control" rows="3"
                                  placeholder="Terms and conditions..."
                                  wire:model.blur="terms"></textarea>
                        @error('terms') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="my-4 p-3 border rounded text-center text-muted">
                        Ad slot (responsive)
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-semibold">{{ number_format($this->subtotal, 2) }}</span>
                    </div>

                    <div class="mt-3 d-flex gap-2">
                        <div class="flex-grow-1">
                            <select class="form-select" wire:model.live="discount_type">
                                <option value="off">Discount off</option>
                                <option value="percent">Discount %</option>
                                <option value="flat">Discount flat</option>
                            </select>
                        </div>
                        <div style="width:140px;">
                            <input type="number" min="0" step="0.01" class="form-control"
                                   wire:model.blur="discount_value">
                        </div>
                    </div>

                    <div class="mt-2 d-flex gap-2">
                        <div class="flex-grow-1">
                            <select class="form-select" wire:model.live="tax_type">
                                <option value="off">Tax off</option>
                                <option value="percent">Tax %</option>
                                <option value="flat">Tax flat</option>
                            </select>
                        </div>
                        <div style="width:140px;">
                            <input type="number" min="0" step="0.01" class="form-control"
                                   wire:model.blur="tax_value">
                        </div>
                    </div>

                    <div class="mt-2 d-flex gap-2">
                        <div class="flex-grow-1">
                            <select class="form-select" wire:model.live="shipping_type">
                                <option value="off">Shipping off</option>
                                <option value="flat">Shipping flat</option>
                            </select>
                        </div>
                        <div style="width:140px;">
                            <input type="number" min="0" step="0.01" class="form-control"
                                   wire:model.blur="shipping_value">
                        </div>
                    </div>

                    <div class="border-top mt-3 pt-3">
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold">Total</span>
                            <span class="fw-semibold">{{ number_format($this->total, 2) }} {{ $currency }}</span>
                        </div>

                        <div class="d-flex justify-content-between mt-2 align-items-center">
                            <span class="text-muted">Amount Paid</span>
                            <div style="width:160px;">
                                <input type="number" min="0" step="0.01" class="form-control"
                                       wire:model.blur="amount_paid">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-2">
                            <span class="text-muted">Balance Due</span>
                            <span class="fw-semibold">{{ number_format($this->balanceDue, 2) }} {{ $currency }}</span>
                        </div>
                    </div>

                    <div class="d-grid mt-3">
                        <button class="btn btn-success"
                                type="button"
                                wire:click="saveAndPrepareDownload"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove>Save to device + Download PDF</span>
                            <span wire:loading>Preparing…</span>
                        </button>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-warning mt-3 mb-0">
                            Fix the highlighted fields before downloading.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Hidden form to download PDF --}}
    <form id="downloadForm" method="POST" action="{{ route('tools.invoice.download') }}" class="d-none">
        @csrf
        <input type="hidden" name="payload" id="payloadInput">
    </form>

    <script>
    (function () {
        const KEY = 'tanzaniabiz_invoice_history_v2';
        const MAX_DAYS = 210;

        function loadAll() {
            try { return JSON.parse(localStorage.getItem(KEY) || '[]'); }
            catch { return []; }
        }
        function saveAll(list) {
            localStorage.setItem(KEY, JSON.stringify(list));
        }
        function cleanup(list) {
            const cutoff = Date.now() - (MAX_DAYS * 24 * 60 * 60 * 1000);
            return list.filter(x => {
                const t = Date.parse(x.saved_at || '');
                return Number.isFinite(t) && t >= cutoff;
            });
        }

        // Livewire asks browser to load invoice by id (from ?load=...)
        window.addEventListener('invoice-request-load', (e) => {
            const id = e.detail.id;
            const list = cleanup(loadAll());
            const found = list.find(x => x.id === id);
            if (found) {
                @this.call('loadFromDevice', found);
            }
        });

        // Save + download flow
        window.addEventListener('invoice-save-and-download', (e) => {
            const payload = e.detail.payload;

            let list = cleanup(loadAll());
            list = list.filter(x => x.id !== payload.id);
            list.unshift(payload);
            saveAll(list);

            document.getElementById('payloadInput').value = JSON.stringify(payload);
            document.getElementById('downloadForm').submit();
        });
    })();
    </script>
</div>


</div>
@endsection
