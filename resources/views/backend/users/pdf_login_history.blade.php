<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Login History Report</title>
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
            margin-bottom: 20px;
            padding: 20px 0;
        }

        .header .logo {
            margin-bottom: 15px;
        }

        .header .logo img {
            max-width: 150px;
            max-height: 100px;
        }

        .header .company-name {
            font-size: 20px;
            font-weight: bold;
            margin: 10px 0;
            color: #000;
        }

        .header h1 {
            color: #000;
            margin: 10px 0;
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
            padding: 8px;
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

        .footer {
            display: none;
        }

        thead {
            display: table-header-group;
        }

        tbody tr {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        @php
        $logoBase64 = '';
            if (!empty($setting->logo)) {
                $logoPath = public_path('/uploads/general/' . $setting->logo);
                $logoBase64 = file_exists($logoPath)
                    ? 'data:image/' .
                        pathinfo($logoPath, PATHINFO_EXTENSION) .
                        ';base64,' .
                        base64_encode(file_get_contents($logoPath))
                    : '';
            }
        @endphp
        <div class="logo">
            <img src="{{ $logoBase64 }}" alt="Company Logo">
        </div>
        <div class="company-name">{{ $setting->name }}</div>
        <h1>Login History Report</h1>
        <p>Generated on {{ $generatedAt->format('F d, Y \a\t h:i A') }}</p>
        <p>Total Records: {{ number_format($totalRecords) }}</p>
    </div>

    <!-- Summary Statistics -->
    <div class="summary">
        @php
            $deviceStats = $logins
                ->groupBy(function ($login) {
                    $userAgent = $login->user_agent;
                    if (preg_match('/iPad/', $userAgent)) {
                        return 'tablet';
                    }
                    if (preg_match('/Mobile|Android|iPhone/', $userAgent)) {
                        return 'mobile';
                    }
                    return 'desktop';
                })
                ->map->count();
        @endphp

        <strong>Device Summary:</strong>
        Desktop: {{ $deviceStats->get('desktop', 0) }} |
        Mobile: {{ $deviceStats->get('mobile', 0) }} |
        Tablet: {{ $deviceStats->get('tablet', 0) }}
    </div>

    <!-- Data Table -->
    @if ($logins->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%">#</th>
                    <th style="width: 25%">Email</th>
                    <th style="width: 20%">Name</th>
                    <th style="width: 18%">Login Time</th>
                    <th style="width: 12%">IP Address</th>
                    <th style="width: 20%">Device/Browser</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logins as $index => $login)
                    @php
                        $userAgent = $login->user_agent;
                        $deviceType = 'Desktop';
                        $deviceClass = 'device-desktop';

                        if (preg_match('/iPad/', $userAgent)) {
                            $deviceType = 'Tablet';
                            $deviceClass = 'device-tablet';
                        } elseif (preg_match('/Mobile|Android|iPhone/', $userAgent)) {
                            $deviceType = 'Mobile';
                            $deviceClass = 'device-mobile';
                        }

                        $browser = 'Unknown';
                        if (preg_match('/Chrome/', $userAgent)) {
                            $browser = 'Chrome';
                        } elseif (preg_match('/Firefox/', $userAgent)) {
                            $browser = 'Firefox';
                        } elseif (preg_match('/Safari/', $userAgent)) {
                            $browser = 'Safari';
                        } elseif (preg_match('/Edge/', $userAgent)) {
                            $browser = 'Edge';
                        }
                    @endphp

                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $login->user->email }}</td>
                        <td>{{ $login->user->name }}</td>
                        <td class="text-nowrap">
                            <div>{{ $login->login_time->format('M d, Y') }}</div>
                            <div style="color: #6c757d; font-size: 9px;">
                                {{ $login->login_time->format('h:i A') }}
                            </div>
                        </td>
                        <td class="font-monospace">
                            {{ $login->ip_address }}
                        </td>
                        <td>
                            <div class="{{ $deviceClass }}">
                                {{ $deviceType }}
                            </div>
                            <div style="color: #6c757d; font-size: 9px;">{{ $browser }}</div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center" style="padding: 50px;">
            <h3 style="color: #6c757d;">No login records found</h3>
        </div>
    @endif

    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_script('
                $text = __("Page :pageNum/:pageCount", ["pageNum" => $PAGE_NUM, "pageCount" => $PAGE_COUNT]);
                $font = null;
                $size = 9;
                $color = array(0,0,0);
                $word_space = 0.0;
                $char_space = 0.0;
                $angle = 0.0;
 
                $textWidth = $fontMetrics->getTextWidth($text, $font, $size);
 
                $x = ($pdf->get_width() - $textWidth) / 2;
                $y = $pdf->get_height() - 35;
 
                $pdf->text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
            ');
        }
    </script>
</body>

</html>
