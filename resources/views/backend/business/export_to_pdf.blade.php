<!DOCTYPE html>
<html>
<head>
    <title>Business Listings</title>
    <style>
        @page { size: A4; }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', sans-serif;
            font-size: 12px;
            line-height: 1;
            color: #000;
        }

        .header { text-align: center; }

        .header h1 {
            color: #000;
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }

        thead { display: table-header-group; }
        tbody tr { page-break-inside: avoid; }
    </style>
</head>
<body>

<div class="header">
    <h1>Business Listings</h1>
    <p>Generated on {{ $generatedAt->format('F d, Y \a\t h:i A') }}</p>
    <p>Total Records: {{ number_format($totalRecords) }}</p>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Category</th>
            <th>City</th>
            <th>Email</th>
            <th>Is Featured</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($listings as $key => $listing)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $listing->name }}</td>
            <td>{{ $listing->category->name ?? '-' }}</td>
            <td>{{ $listing->city->city_name ?? '-' }}</td>
            <td>{{ $listing->email }}</td>
            <td>{{ $listing->is_featured ? 'Yes' : 'No' }}</td>
            <td>{{ $listing->status ? 'Active' : 'Inactive' }}</td>
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

            $textWidth = $fontMetrics->getTextWidth($text, $font, $size);
            $x = ($pdf->get_width() - $textWidth) / 2;
            $y = $pdf->get_height() - 35;

            $pdf->text($x, $y, $text, $font, $size, $color);
        ');
    }
</script>

</body>
</html>