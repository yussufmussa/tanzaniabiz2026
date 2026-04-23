<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 18px 18px 45px 18px; /* bottom margin for footer */
        }

        body {
            margin: 0;
            padding: 0;
            font-family: "Times New Roman", serif;
            font-size: 10px;
            line-height: 1.15;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 12px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
        }

        .header p {
            margin: 4px 0;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* helps dompdf wrap text reliably */
        }

        thead {
            display: table-header-group; /* repeat header on each page */
        }

        th, td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: top;
            word-break: break-word;
            overflow-wrap: anywhere;
        }

        tbody tr {
            page-break-inside: avoid; /* prevents row splitting */
        }

        .text-center { text-align: center; }
        .text-nowrap { white-space: nowrap; }

        /* Column widths (tweak as needed) */
        .col-idx      { width: 3%; }
        .col-name     { width: 12%; }
        .col-email    { width: 16%; }
        .col-verified { width: 7%; }
        .col-active   { width: 6%; }
        .col-created  { width: 10%; }
        .col-listings { width: 6%; }
        .col-roles    { width: 10%; }
        .col-perms    { width: 30%; }

        .small { font-size: 9px; }
    </style>
</head>

<body>
    <div class="header">
        <h1>User List</h1>
        <p>Generated on {{ $generatedAt->format('F d, Y \a\t h:i A') }}</p>
        <p>Total Records: {{ number_format($totalRecords) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="col-idx text-center">#</th>
                <th class="col-name">Full Name</th>
                <th class="col-email">Email</th>
                <th class="col-verified text-center">Verified?</th>
                <th class="col-active text-center">Active?</th>
                <th class="col-created text-nowrap">Created At</th>
                <th class="col-listings text-center"># Listings</th>
                <th class="col-roles">Roles</th>
                <th class="col-perms">Permissions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($users as $i => $user)
                @php
                    $roles = $user->roles?->pluck('name')->implode(', ') ?: '-';

                    // If you're using Spatie Permission:
                    // getAllPermissions() merges direct + role perms. Since we eager loaded roles.permissions and permissions,
                    // this won’t cause extra queries.
                    $permissions = $user->getAllPermissions()
                        ->pluck('name')
                        ->unique()
                        ->values()
                        ->implode(', ') ?: '-';
                @endphp

                <tr>
                    <td class="col-idx text-center">{{ $i + 1 }}</td>
                    <td class="col-name">{{ $user->name }}</td>
                    <td class="col-email">{{ $user->email }}</td>
                    <td class="col-verified text-center">{{ $user->email_verified_at ? 'Yes' : 'No' }}</td>
                    <td class="col-active text-center">{{ $user->is_active ? 'Yes' : 'No' }}</td>
                    <td class="col-created text-nowrap">{{ optional($user->created_at)->format('Y-m-d H:i') }}</td>
                    <td class="col-listings text-center">{{ number_format($user->business_listings_count ?? 0) }}</td>
                    <td class="col-roles">{{ $roles }}</td>
                    <td class="col-perms small">{{ $permissions }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Page numbers (requires isPhpEnabled + enable_php=true) --}}
    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_script('
                $text = "Page " . $PAGE_NUM . " / " . $PAGE_COUNT;
                $font = $fontMetrics->get_font("Helvetica", "normal");
                $size = 9;
                $x = ($pdf->get_width() - $fontMetrics->get_text_width($text, $font, $size)) / 2;
                $y = $pdf->get_height() - 28;
                $pdf->text($x, $y, $text, $font, $size);
            ');
        }
    </script>
</body>
</html>