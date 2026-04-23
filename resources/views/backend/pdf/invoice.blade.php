<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        @page {
            size: A4;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Helvetica;
            font-size: 12px;
            line-height: 1;
            color: #000000;
            background: white;
        }

        .invoice-header {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .invoice-title {
            display: table-cell;
            vertical-align: top;
            width: 50%;
        }

        .invoice-title h1 {
            font-size: 28px;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .invoice-meta {
            display: table-cell;
            vertical-align: top;
            text-align: right;
            width: 50%;
        }

        .invoice-meta table {
            margin-left: auto;
        }

        .invoice-meta td {
            padding: 3px 0;
            padding-left: 15px;
        }

        .invoice-meta td:first-child {
            font-weight: bold;
            padding-left: 0;
        }

        .billing-section {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }

        .from-section,
        .to-section {
            display: table-cell;
            vertical-align: top;
            width: 50%;
            padding-right: 20px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .company-info {
            line-height: 1.6;
        }

        .company-name {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .items-table th {
            background-color: #D8DADB;
            padding: 10px 8px;
            border: 1px solid #e0e0e0;
            font-weight: bold;
            text-align: left;
            color: #000000;
        }

        .items-table td {
            padding: 10px 8px;
            border: 1px solid #e0e0e0;
            vertical-align: top;
        }


        .totals-section {
            float: right;
            width: 35%;
            /* aligns with the last columns */
            margin-top: -1px;
            /* aligns perfectly with the items table */
        }

        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 8px 8px;
            border: none;
            /* remove all borders first */
        }

        .totals-table td:first-child {
            font-weight: bold;
            text-align: right;
            padding-right: 10px;
        }

        .totals-table td:last-child {
            text-align: right;
            border-left: 1px solid #e0e0e0;
            border-right: 1px solid #e0e0e0;
            /* only right column has border */
            border-top: 1px solid #e0e0e0;
            /* connects with above table */
            width: 120px;
        }

        /* Make Total row stand out */
        .totals-table .total-row td:first-child {
            font-weight: bold;
        }

        .totals-table .total-row td:last-child {
            font-weight: bold;
        }

        .instructions-section {
            clear: both;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #2c3e50;
        }

        .instructions-content {
            background-color: #f8f9fa;
            padding: 20px;
            /* border-left: 4px solid #2c3e50; */
            margin-top: 15px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }

        /* PDF-specific styles */
        @media print {
            @page {
                size: A4 portrait;
                margin: 0;
            }

            body {
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-header">
        <div class="invoice-title">
            <h1>INVOICE</h1>
        </div>
        <div class="invoice-meta">
            <table>
                <tr>
                    <td>Invoice #:</td>
                    <td>{{ $invoice->invoice_number }}</td>
                </tr>
                <tr>
                    <td>Date:</td>
                    <td>{{ $invoice->invoice_date->format('d M Y') }}</td>
                </tr>
                <tr>
                    <td>Due Date:</td>
                    <td>{{ $invoice->invoice_date->format('d M Y') }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="billing-section">
        <div class="from-section">
            <div class="section-title">From</div>
            <div class="company-info">
                {!! nl2br($invoice->from) !!}
            </div>
        </div>

        <div class="to-section">
            <div class="section-title">Bill To</div>
            <div class="company-info">
                {!! nl2br($invoice->billed_to) !!}
            </div>
        </div>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 50%;">Item/Description</th>
                <th style="width: 15%;">Qty</th>
                <th style="width: 15%;">Rate</th>
                <th style="width: 20%;">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ number_format($item->quantity) }}</td>
                    <td>${{ number_format($item->rate, 2) }}</td>
                    <td>{{ number_format($item->amount, 2) }}</td>
                </tr>
            @endforeach
            <tr >
                <td colspan="2" style="border:none;"></td>
                <td style="text-align: right; font-weight: bold; border:none;">Subtotal:</td>
                <td style="border-left: 1px solid #e0e0e0; text-align: left;">${{ number_format($invoice->subtotal,2) }}</td>
            </tr>
            @if($invoice->tax_rate > 0)
            <tr>
                <td colspan="2" style="border:none;"></td>
                <td style="text-align: right; font-weight: bold; border:none;">Tax ({{ number_format($invoice->tax_rate,2) }}):</td>
                <td style="border-left: 1px solid #e0e0e0; text-align: left;">${{ number_format($invoice->tax_amount) }}</td>
            </tr>
            @endif
                @if($invoice->discount_rate > 0)
            <tr>
                <td colspan="2" style="border:none;"></td>
                <td style="text-align: right; font-weight: bold; border:none;">Discount ({{ $invoice->discount_rate }}):</td>
                <td style="border-left: 1px solid #e0e0e0; text-align: leftt;">-${{ number_format($invoice->discount_amount,2) }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td colspan="2" style="border:none;"></td>
                <td style="text-align: right; font-weight: bold; border:none;">Total:</td>
                <td style="border-left: 1px solid #e0e0e0; text-align: left; font-weight: bold;">
                    ${{ number_format($invoice->total,2) }}</td>
            </tr>
            @if($invoice->amount_paid > 0)
            <tr>
                <td colspan="2" style="border:none;"></td>
                <td style="text-align: right; font-weight: bold; border:none;">Paid:</td>
                <td style="border-left: 1px solid #e0e0e0; text-align: left;">-${{ number_format($invoice->amount_paid,2) }}</td>
            </tr>
            @endif
            <tr>
                <td colspan="2" style="border:none;"></td>
                <td style="text-align: right; font-weight: bold; border:none;">Balance Due:</td>
                <td style="border-left: 1px solid #e0e0e0; text-align: left; font-weight: bold;">
                    ${{ number_format(($invoice->total - $invoice->amount_paid),2 ) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="instructions-section">
        <div class="section-title">Notes & Terms</div>
        <div class="instructions-content">
            <p>{!! nl2br($invoice->notes) !!}</p>
        </div>
    </div>
</body>

</html>
