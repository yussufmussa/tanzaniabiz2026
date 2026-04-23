<!DOCTYPE html>
<html>

<head>
    <title>Order Report</title>
    <style>
        @page {
            size: A4;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', sans-serif;
            font-size: 12px;
            line-height: 1;
            color: #000;
        }

        .header {
            text-align: center;
        }

        .header h1 {
            color: #000;
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .date-range {
            text-align: center;
            margin: 10px 0;
            padding: 8px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            font-weight: bold;
            color: #495057;
        }

        .summary {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }


        .page-break {
            page-break-before: always;
        }

        .text-center {
            text-align: center;
        }

        .text-nowrap {
            white-space: nowrap;
        }


        .font-monospace {
            font-family: 'Courier New', monospace;
        }

        /* Remove the fixed footer as we're using @page for footer */
        .footer {
            display: none;
        }

        /* Ensure table headers repeat on each page */
        thead {
            display: table-header-group;
        }

        tbody tr {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Order List</h1>
        <p>Generated on {{ $generatedAt->format('F d, Y \a\t h:i A') }}</p>
        
        @if(isset($fromDate) || isset($toDate))
            <div class="date-range">
                @if(isset($fromDate) && isset($toDate))
                    Report Period: {{ \Carbon\Carbon::parse($fromDate)->format('F d, Y') }} - {{ \Carbon\Carbon::parse($toDate)->format('F d, Y') }}
                @elseif(isset($fromDate))
                    From: {{ \Carbon\Carbon::parse($fromDate)->format('F d, Y') }} onwards
                @elseif(isset($toDate))
                    Up to: {{ \Carbon\Carbon::parse($toDate)->format('F d, Y') }}
                @endif
            </div>
        @endif
        
        <p>Total Records: {{ number_format($totalRecords) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Order #</th>
                <th>Customer</th>
                <th>Order On</th>
                <th>Item(s)</th>
                <th>Total</th>
                <th>Order Status</th>
                <th>Payment Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $key => $order)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    <td>{{ $order->orderItem->count() }}</td>
                    <td>{{number_format($order->total,2)}}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->payment_status }}</td>
                </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center;">No records for this search</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_script('
                $text = $text = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT;
                $font = null;
                $size = 9;
                $color = array(0,0,0);
                $word_space = 0.0;  //  default
                $char_space = 0.0;  //  default
                $angle = 0.0;   //  default
 
                $textWidth = $fontMetrics->getTextWidth($text, $font, $size);
 
                $x = ($pdf->get_width() - $textWidth) / 2;
                $y = $pdf->get_height() - 35;
 
                $pdf->text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
            ');
        }
    </script>
</body>

</html>