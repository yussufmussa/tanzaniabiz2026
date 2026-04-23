<!DOCTYPE html>
<html>

<head>
    <title>Brands Export</title>
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
        <h1>Brand List</h1>
        <p>Generated on {{ $generatedAt->format('F d, Y \a\t h:i A') }}</p>
        <p>Total Records: {{ number_format($totalRecords) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>No. of Products</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($brands as $key => $brand)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $brand->name }}</td>
                    <td>{{ $brand->products_count }}</td>
                    <td>{{ $brand->is_active ? 'Active' : 'Inactive' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_script('
                $text = __("Page :pageNum/:pageCount", ["pageNum" => $PAGE_NUM, "pageCount" => $PAGE_COUNT]);
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
