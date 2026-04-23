@extends('frontend.layouts.base')

@section('contents')
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 mb-1">Invoice History</h1>
            <div class="text-muted small">Saved on this device for ~7 months.</div>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-primary" href="{{ route('tools.invoice') }}">Back to generator</a>
            <button class="btn btn-outline-danger" id="clearAllBtn" type="button">Clear all</button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-sm align-middle" id="historyTable">
            <thead>
                <tr class="text-muted">
                    <th>Date</th>
                    <th>Invoice #</th>
                    <th>Bill To</th>
                    <th class="text-end">Total</th>
                    <th>Currency</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan="6" class="text-muted">Loading…</td></tr>
            </tbody>
        </table>
    </div>

    <div class="my-4 p-3 border rounded text-center text-muted">
        Ad slot (responsive)
    </div>

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
        function n(v){ return (v === '' || v === null || typeof v === 'undefined') ? 0 : Number(v); }
        function money(x){ x = Number(x); return Number.isFinite(x) ? x.toFixed(2) : '0.00'; }

        function computeTotal(inv) {
            let subtotal = 0;
            (inv.items || []).forEach(it => subtotal += n(it.qty) * n(it.unit_price));
            subtotal = Math.max(0, subtotal);

            let disc = 0;
            if (inv.discount_type === 'percent') disc = Math.min(subtotal, subtotal * (n(inv.discount_value)/100));
            if (inv.discount_type === 'flat') disc = Math.min(subtotal, n(inv.discount_value));
            disc = Math.max(0, disc);

            const base = Math.max(0, subtotal - disc);

            let tax = 0;
            if (inv.tax_type === 'percent') tax = base * (n(inv.tax_value)/100);
            if (inv.tax_type === 'flat') tax = n(inv.tax_value);
            tax = Math.max(0, tax);

            let ship = 0;
            if (inv.shipping_type === 'flat') ship = n(inv.shipping_value);
            ship = Math.max(0, ship);

            return Math.max(0, base + tax + ship);
        }

        function shortLine(text) {
            if (!text) return '-';
            return String(text).split('\n')[0].slice(0, 40);
        }

        function render() {
            let list = cleanup(loadAll());
            saveAll(list);

            const tbody = document.querySelector('#historyTable tbody');
            tbody.innerHTML = '';

            if (!list.length) {
                tbody.innerHTML = `<tr><td colspan="6" class="text-muted">No invoices saved on this device.</td></tr>`;
                return;
            }

            list.forEach(inv => {
                const date = inv?.invoice?.date || (inv.saved_at || '').slice(0,10) || '-';
                const num = inv?.invoice?.number || '-';
                const bill = shortLine(inv.bill_to_text);
                const total = computeTotal(inv);

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${date}</td>
                    <td>${num}</td>
                    <td>${bill}</td>
                    <td class="text-end">${money(total)}</td>
                    <td>${inv.currency || '-'}</td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-primary" href="{{ route('tools.invoice') }}?load=${encodeURIComponent(inv.id)}">Open</a>
                        <button class="btn btn-sm btn-outline-danger" data-del="1">Delete</button>
                    </td>
                `;

                tr.querySelector('[data-del="1"]').addEventListener('click', () => {
                    let cur = cleanup(loadAll()).filter(x => x.id !== inv.id);
                    saveAll(cur);
                    render();
                });

                tbody.appendChild(tr);
            });
        }

        document.getElementById('clearAllBtn')?.addEventListener('click', () => {
            if (!confirm('Clear all saved invoices from this device?')) return;
            localStorage.removeItem(KEY);
            render();
        });

        render();
    })();
    </script>
</div>

@endsection
