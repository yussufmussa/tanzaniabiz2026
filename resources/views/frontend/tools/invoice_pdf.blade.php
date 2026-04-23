<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }

        .muted {
            color: #222;
        }

        .row {
            display: flex;
            justify-content: space-between;
            gap: 24px;
        }

        .col {
            width: 48%;
        }

        h1 {
            font-size: 28px;
            letter-spacing: 2px;
            font-weight: 400;
            margin: 0;
            text-align: right;
        }

        .meta {
            text-align: right;
        }

        .meta div {
            margin: 2px 0;
        }

        hr {
            border: 0;
            border-top: 1px solid #000;
            margin: 12px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 8px 6px;
            border-bottom: 1px solid #000;
        }

        th {
            text-align: left;
            font-weight: 600;
        }

        .right {
            text-align: right;
        }

        .totals {
            width: 320px;
            margin-left: auto;
            border-top: 1px solid #000;
        }

        .totals td {
            border-bottom: none;
            padding: 6px 0;
        }

        .totals .label {
            width: 55%;
        }

        .totals .value {
            width: 45%;
            text-align: right;
        }

        .section-title {
            font-weight: 700;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="row">
        <div>
            <div class="section-title">INVOICE</div>
            <div class="muted">Invoice #: {{ $invoice['number'] ?: '-' }}</div>
            <div class="muted">Date: {{ $invoice['date'] }}</div>
            <div class="muted">Due Date: {{ $invoice['due_date'] }}</div>
            @if (!empty($invoice['payment_terms']))
                <div class="muted">Payment Terms: {{ $invoice['payment_terms'] }}</div>
            @endif
        </div>
        <div class="meta">
            <h1>INVOICE</h1>
            @if (!empty($logo_data_url))
                <img src="{{ $logo_data_url }}" alt="Logo"
                    style="max-height:70px; max-width:220px; object-fit:contain;">
            @endif
        </div>

    </div>

    <hr>

    <table width="100%" cellspacing="0" cellpadding="0" style="margin-top: 10px;">
        <tr>
            <!-- FROM -->
            <td width="50%" valign="top" style="padding-right: 20px;">
                <div style="font-weight:700; margin-bottom:6px;">FROM</div>
                {!! nl2br(e($from_text ?? '')) !!}
            </td>

            <!-- BILL TO -->
            <td width="50%" valign="top" style="padding-left: 20px;">
                <div style="font-weight:700; margin-bottom:6px;">BILL TO</div>
                {!! nl2br(e($bill_to_text ?? '')) !!}
            </td>
        </tr>
    </table>



    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th class="right">Qty</th>
                <th class="right">Rate</th>
                <th class="right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $it)
                @php
                    $qty = (float) ($it['qty'] ?? 0);
                    $price = (float) ($it['unit_price'] ?? 0);
                    $amt = max(0, $qty * $price);
                @endphp
                <tr>
                    <td>{{ $it['description'] }}</td>
                    <td class="right">{{ rtrim(rtrim(number_format($qty, 2), '0'), '.') }}</td>
                    <td class="right">{{ number_format($price, 2) }}</td>
                    <td class="right">{{ number_format($amt, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td class="label">Subtotal:</td>
            <td class="value">{{ number_format($subtotal, 2) }} {{ $currency }}</td>
        </tr>

        @if (($taxAmount ?? 0) > 0)
            <tr>
                <td class="label">Tax:</td>
                <td class="value">{{ number_format($taxAmount, 2) }} {{ $currency }}</td>
            </tr>
        @endif

        @if (($discountAmount ?? 0) > 0)
            <tr>
                <td class="label">Discount:</td>
                <td class="value">-{{ number_format($discountAmount, 2) }} {{ $currency }}</td>
            </tr>
        @endif


        <tr>
            <td class="label"><strong>Total:</strong></td>
            <td class="value"><strong>{{ number_format($total, 2) }} {{ $currency }}</strong></td>
        </tr>

        @if (($amount_paid ?? 0) > 0)
            <tr>
                <td class="label">Amount Paid:</td>
                <td class="value">{{ number_format($amount_paid, 2) }} {{ $currency }}</td>
            </tr>
            <tr>
                <td class="label"><strong>Balance Due:</strong></td>
                <td class="value"><strong>{{ number_format($balance_due, 2) }} {{ $currency }}</strong></td>
            </tr>
        @endif
    </table>

    @if (!empty($payment_details))
        <div style="margin-top:14px;">
            <div class="section-title">PAYMENT DETAILS</div>
            {!! nl2br(e($payment_details)) !!}
        </div>
    @endif

    @if (!empty($terms))
        <div style="margin-top:14px;">
            <div class="section-title">TERMS</div>
            {!! nl2br(e($terms)) !!}
        </div>
    @endif

</body>

</html>
