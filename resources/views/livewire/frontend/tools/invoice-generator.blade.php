<div>
<div class="container py-4" x-data x-init="@this.loadFromQuery(new URLSearchParams(window.location.search).get('load'))">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 mb-1">Invoice Generator</h1>
            {{-- <div class="text-muted small">Invoices are saved on your device (local storage).</div> --}}
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-secondary" href="{{ route('tools.invoice.history') }}">History</a>
        </div>
    </div>

    {{-- Ad slot - Top banner --}}
    <div class="mb-4 p-3 border rounded text-center text-muted bg-light">
        Ad slot (top banner - 728x90 or responsive)
    </div>

    
    <div class="row g-4">
        {{-- LEFT: invoice --}}
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    {{-- TOP: Logo (left) + Title/# + meta (right) --}}
                    <div class="row g-4 align-items-start mb-4">
                        <div class="col-md-6">
                            <input id="logoInput" type="file" accept="image/png,image/jpeg,image/webp" class="d-none"
                                wire:model="logo">

                            <label for="logoInput" class="border rounded p-3 d-flex align-items-center justify-content-center w-100" style="min-height: 120px; cursor: pointer; background-color: #f8f9fa;">
                                @if ($logo_preview_data_url)
                                    <div class="text-center w-100 p-3">
                                        <img src="{{ $logo_preview_data_url }}" alt="Logo preview"
                                            style="max-height:110px; max-width:100%; object-fit:contain;">
                                        <div class="small mt-2 text-muted">Click to change</div>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <div class="fs-5">+ Add Your Logo</div>
                                    </div>
                                @endif
                            </label>

                            @error('logo')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror

                            {{-- FROM BOX (under logo) --}}
                            <div class="border rounded p-3 mt-3">
                                <label class="form-label mb-2 fw-bold small">FROM</label>
                                <textarea  class="form-control small border-0" placeholder="Business name&#10;Phone&#10;Email&#10;Address&#10;TIN/VRN (optional)"
                                    wire:model.blur="from_text"></textarea>
                                @error('from_text')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex justify-content-end">
                                <div class="text-end">
                                    <h2 class="display-6 fw-bold mb-3">INVOICE</h2>
                                    <div class="d-flex justify-content-end align-items-center gap-2 mt-2">
                                        <span class="fw-semibold">#</span>
                                        <input class="form-control" style="max-width:220px;" placeholder="Invo-000878"
                                            wire:model.blur="invoice.number">
                                    </div>
                                    @error('invoice.number')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Meta fields --}}
                            <div class="mt-4">
                                <div class="row g-2 align-items-center mb-2">
                                    <div class="col-5 text-end fw-semibold small">Date</div>
                                    <div class="col-7">
                                        <input type="date" class="form-control form-control-sm" wire:model.blur="invoice.date">
                                        @error('invoice.date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row g-2 align-items-center mb-2">
                                    <div class="col-5 text-end fw-semibold small">Payment Terms</div>
                                    <div class="col-7">
                                        <input class="form-control form-control-sm" placeholder="e.g. Pay within 7 days"
                                            wire:model.blur="invoice.payment_terms">
                                        @error('invoice.payment_terms')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row g-2 align-items-center mb-2">
                                    <div class="col-5 text-end fw-semibold small">Due Date</div>
                                    <div class="col-7">
                                        <input type="date" class="form-control form-control-sm" wire:model.blur="invoice.due_date">
                                        @error('invoice.due_date')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- BILL TO --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="border rounded p-3 ">
                                <div class="fw-bold small mb-2">Bill To</div>
                                <textarea class="form-control border-0 " placeholder="Customer name&#10;Phone&#10;Email&#10;Address"
                                    wire:model.blur="bill_to_text"></textarea>
                                @error('bill_to_text')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- ITEMS TABLE --}}
                    <div class="border-bottom pb-2 mb-3 d-flex align-items-center fw-semibold small text-muted">
                        <div class="flex-grow-1">Item/Product</div>
                        <div class="text-center" style="width: 90px;">Quantity</div>
                        <div class="text-center" style="width: 120px;">Price</div>
                        <div class="text-end" style="width: 120px;">Amount</div>
                        <div style="width:40px;"></div>
                    </div>

                    <div class="mb-3">
                        @foreach ($items as $i => $item)
                            @php
                                $q = (float) ($item['qty'] ?? 0);
                                $p = (float) ($item['unit_price'] ?? 0);
                                $amt = max(0, $q * $p);
                            @endphp

                            <div class="border-bottom pb-2 mb-2">
                                <div class="d-flex align-items-start gap-2">
                                    <div class="flex-grow-1">
                                        <input class="form-control border-1" placeholder="Description"
                                            wire:model.blur="items.{{ $i }}.description">
                                        @error("items.$i.description")
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div style="width: 70px;">
                                        <input type="number" min="0" step="1"
                                            class="form-control form-control-sm text-center"
                                            wire:model.blur="items.{{ $i }}.qty">
                                        @error("items.$i.qty")
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div style="width: 120px;">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">
                                                {{ $currency === 'USD' ? '$' : ($currency === 'EUR' ? '€' : 'TZS') }}
                                            </span>
                                            <input type="number" min="0" step="1"
                                                class="form-control text-center"
                                                wire:model.blur="items.{{ $i }}.unit_price">
                                        </div>
                                        @error("items.$i.unit_price")
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div  class="text-end pt-1">
                                        <div class="fw-semibold">
                                            {{ number_format($amt, 2) }}
                                            {{ $currency === 'USD' ? '$' : ($currency === 'EUR' ? '€' : 'TZS') }}
                                        </div>
                                    </div>

                                    <div style="width:10px;" class="text-end pt-1">
                                        <button class="btn btn-sm btn-link text-danger p-0" type="button"
                                            wire:click="removeItem({{ $i }})"
                                            title="Remove item">×</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <button class="btn btn-outline-success btn-sm mt-2" type="button" wire:click="addItem">
                            + Add Item
                        </button>
                    </div>

                    {{-- BOTTOM: Payment Details + Terms (left) / Totals (right) --}}
                    <div class="row g-4 mt-3">

                        {{-- Left: Payment Details + Terms --}}
                        <div class="col-md-7">
                            {{-- Payment Details --}}
                            <div class="mb-3">
                                <label class="form-label mb-2 fw-semibold">Payment Details</label>
                                <textarea class="form-control" rows="3"
                                    placeholder="Bank Name: CRDB BANK&#10;Account Number: 0152530223400&#10;Account Name: Yussuf Hamad Mussa"
                                    wire:model.blur="payment_details"></textarea>
                                @error('payment_details')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Terms --}}
                            <div class="mb-0">
                                <label class="form-label mb-2 fw-semibold">Terms</label>
                                <textarea class="form-control" rows="2"
                                    placeholder="Terms and conditions - late fees, payment methods, delivery schedule" wire:model.blur="terms"></textarea>
                                @error('terms')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Right: Totals --}}
                        <div class="col-md-5">
                            <div class="border rounded p-3 bg-light">
                                {{-- Subtotal --}}
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal</span>
                                    <span class="fw-semibold">{{ number_format($this->subtotal, 2) }}
                                        {{ $currency }}</span>
                                </div>

                                {{-- Discount --}}
                                <div class="mb-2">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="text-muted small">Discount</span>
                                        <div class="d-flex gap-2">
                                            <select class="form-select" wire:model.live="discount_type">
                                                <option value="off">Off</option>
                                                <option value="percent">%</option>
                                                <option value="flat">Flat</option>
                                            </select>

                                            @if ($discount_type !== 'off')
                                                <input type="number" min="0" step="1"
                                                    class="form-control text-end" 
                                                    placeholder="0.00" wire:model.blur="discount_value">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Tax --}}
                                <div class="mb-2">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="text-muted small">Tax</span>
                                        <div class="d-flex gap-2">
                                            <select class="form-select" wire:model.live="tax_type"
                                                >
                                                <option value="off">Off</option>
                                                <option value="percent">%</option>
                                                <option value="flat">Flat</option>
                                            </select>

                                            @if ($tax_type !== 'off')
                                                <input type="number" min="0" 
                                                    class="form-control form-control-sm text-end"
                                                    placeholder="0.00" wire:model.blur="tax_value">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                
                                {{-- Total --}}
                                <div class="d-flex justify-content-between mb-3 border-top pt-2">
                                    <span class="fw-bold">Total</span>
                                    <span class="fw-bold fs-5">{{ number_format($this->total, 2) }}
                                        {{ $currency }}</span>
                                </div>

                                {{-- Amount Paid --}}
                                <div class="mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="form-label mb-0 small">Amount Paid</label>
                                        <div style="width: 150px;">
                                            <div class="input-group input-group-sm">
                                                <span
                                                    class="input-group-text">{{ $currency === 'USD' ? '$' : ($currency === 'EUR' ? '€' : 'TSh') }}</span>
                                                <input type="number" min="0" 
                                                    class="form-control text-end" placeholder="0.00"
                                                    wire:model.blur="amount_paid">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Balance Due --}}
                                <div class="d-flex justify-content-between border-top pt-2">
                                    <span class="fw-bold">Balance Due</span>
                                    <span class="fw-bold fs-5 text-success">{{ number_format($this->balanceDue, 2) }}
                                        {{ $currency }}</span>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            {{-- Ad slot - Below form (mobile) --}}
            <div class="d-lg-none mt-4 p-3 border rounded text-center text-muted bg-light">
                Ad slot (mobile - responsive)
            </div>
        </div>

        {{-- RIGHT: sidebar --}}
        <div class="col-lg-3">
            <div class="sticky-top" style="top: 20px;">
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-grid">
                            <button class="btn btn-success btn-lg" type="button" wire:click="saveAndPrepareDownload"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove>⬇ Download</span>
                                <span wire:loading>Preparing…</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label mb-2 fw-semibold">Theme</label>
                            <select class="form-select" disabled>
                                <option>Classic</option>
                            </select>
                            <small class="text-muted">More themes coming soon</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label mb-2 fw-semibold">Currency</label>
                            <select class="form-select" wire:model.live="currency">
                                <option value="TZS">TZS (TSh)</option>
                                <option value="USD">USD ($)</option>
                                <option value="EUR">EUR (€)</option>
                            </select>
                            @error('currency')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-center">
                            <button class="btn btn-outline-secondary btn-sm" type="button" disabled>
                                Save Default
                            </button>
                            <small class="text-muted d-block mt-1">Feature coming soon</small>
                        </div>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert alert-warning small">
                        Please fix the highlighted fields before downloading.
                    </div>
                @endif

                <div class="p-3 border rounded text-center text-muted bg-light">
                    Ad slot (sidebar - 300x250 or 300x600)
                </div>
            </div>
        </div>
    </div>

    {{-- Ad slot - Bottom banner --}}
    <div class="mt-4 p-3 border rounded text-center text-muted bg-light">
        Ad slot (bottom banner - 728x90 or responsive)
    </div>

    {{-- Hidden form to download PDF --}}
    <form id="downloadForm" method="POST" action="{{ route('tools.invoice.download') }}" class="d-none">
        @csrf
        <input type="hidden" name="payload" id="payloadInput">
    </form>

    <script>
        (function() {
            const KEY = 'tanzaniabiz_invoice_history_v2';
            const MAX_DAYS = 210;

            function loadAll() {
                try {
                    return JSON.parse(localStorage.getItem(KEY) || '[]');
                } catch {
                    return [];
                }
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

            window.addEventListener('invoice-request-load', (e) => {
                const id = e.detail.id;
                const list = cleanup(loadAll());
                const found = list.find(x => x.id === id);
                if (found) {
                    @this.call('loadFromDevice', found);
                }
            });

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