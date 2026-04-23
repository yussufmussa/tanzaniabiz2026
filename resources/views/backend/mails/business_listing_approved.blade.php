<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listing Approved - TanzaniaBiz</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            line-height: 1.65;
            color: #262626;
            background-color: #fafafa;
            margin: 0;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #e5e5e5;
        }

        .header {
            padding: 28px 30px;
            border-bottom: 3px solid #D23A40;
            text-align: center;
        }

        .header h1 {
            font-size: 22px;
            margin: 0;
            font-weight: 700;
            letter-spacing: 2px;
            color: #D23A40;
            text-transform: uppercase;
        }

        .header p {
            font-size: 12px;
            margin: 8px 0 0 0;
            color: #737373;
            letter-spacing: 1px;
        }

        .content {
            padding: 35px 30px;
        }

        .status-tag {
            display: inline-block;
            padding: 4px 14px;
            margin-bottom: 28px;
            background-color: #D23A40;
            font-size: 11px;
            font-weight: 700;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border: 2px solid #D23A40;
        }

        .company-name {
            font-weight: 700;
            color: #D23A40;
        }

        .content p {
            margin-bottom: 18px;
            color: #262626;
            font-size: 14px;
        }

        .section-title {
            font-size: 13px;
            font-weight: 700;
            margin-top: 36px;
            margin-bottom: 14px;
            color: #D23A40;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .notice-box {
            border: 3px solid #D23A40;
            padding: 0;
            margin: 32px 0;
            background-color: #fff5f5;
        }

        .notice-box-header {
            background-color: #D23A40;
            padding: 14px 20px;
            color: #ffffff;
        }

        .notice-box-header h4 {
            margin: 0;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .notice-box-inner {
            padding: 20px;
        }

        .notice-box-inner p {
            color: #7f1d1d;
            margin-bottom: 14px;
            font-weight: 600;
            font-size: 14px;
        }

        .notice-box ul {
            margin: 14px 0;
            padding-left: 0;
            list-style: none;
        }

        .notice-box li {
            margin-bottom: 10px;
            color: #991b1b;
            font-weight: 600;
            padding-left: 24px;
            position: relative;
            font-size: 14px;
        }

        .notice-box li::before {
            content: "→";
            position: absolute;
            left: 0;
            color: #D23A40;
            font-weight: 700;
            font-size: 16px;
        }

        .notice-box .emphasis {
            color: #7f1d1d;
            font-weight: 700;
            font-size: 15px;
            margin-top: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        ul {
            margin: 14px 0;
            padding-left: 20px;
        }

        ul li {
            margin-bottom: 10px;
            color: #525252;
            font-size: 14px;
        }

        .login-link {
            display: inline-block;
            margin: 28px 0;
            padding: 16px 40px;
            background-color: #D23A40;
            color: #ffffff !important;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border: 3px solid #D23A40;
            transition: all 0.15s ease;
        }

        .login-link:hover {
            background-color: #ffffff;
            color: #D23A40 !important;
        }

        .footer {
            background-color: #fafafa;
            padding: 24px 30px;
            border-top: 1px solid #e5e5e5;
            font-size: 13px;
            text-align: center;
        }

        .footer p {
            margin: 6px 0;
            color: #737373;
        }

        hr {
            border: none;
            border-top: 1px solid #e5e5e5;
            margin: 28px 0;
        }

        a {
            color: #1a1a1a;
            text-decoration: underline;
        }

        a:hover {
            color: #404040;
        }

        center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>TanzaniaBiz</h1>
            <p>Local Business Directory</p>
        </div>

        <div class="content">
            <div class="status-tag">
                Listing Approved
            </div>

            <p>Hi {{ $listing->name }},</p>

            <p>Good news! Your business listing <span class="company-name"><a href="{{ $listing->name }}"
                        target="_blank">{{ $listing->name }}</a></span> is now live on TanzaniaBiz.</p>

            @php
                $hasPhotos = $listing->photos?->count() > 0;
                $hasProducts = $listing->products?->count() > 0;
                $hasExtraInfo = $listing->workingHours?->count() > 0 || $listing->socialMedia?->count() > 0;
                $isComplete = $hasPhotos && $hasProducts && $hasExtraInfo;
            @endphp

            @if (!$hasPhotos || !$hasProducts || !$hasExtraInfo)
                <div class="notice-box">
                    <div class="notice-box-header">
                        <h4>Missing Information</h4>
                    </div>
                    <div class="notice-box-inner">
                        <p>Your listing is incomplete. Fill these sections to get more customers:</p>
                        <ul>
                            @if (!$hasPhotos)
                                <li>Business photos</li>
                            @endif
                            @if (!$hasProducts)
                                <li>Products & services</li>
                            @endif
                            @if (!$hasExtraInfo)
                                <li>Working hours & social links</li>
                            @endif
                        </ul>
                        <p class="emphasis">Complete profiles get 5x more inquiries</p>
                    </div>
                </div>

                <center>
                    <a href="https://tanzaniabiz.com/login" class="login-link" target="_blank">Complete Profile</a>
                </center>
            @endif

            <p class="section-title">Free tools for your business</p>
            <ul>
                <li><a href="https://tanzaniabiz.com/invoice-generator" target="_blank">Invoice Generator</a></li>
                <li><a href="https://tanzaniabiz.com/qr-code-generator" target="_blank">QR Code Generator</a></li>
            </ul>

            <hr>

            <p class="section-title">What you can do with your account</p>
            <ul>
                <li>List up to 3 businesses</li>
                <li>Post job openings</li>
                <li>Update your information anytime</li>
                <li>Control your listing visibility</li>
            </ul>

            <p style="margin-top: 28px;">Need help? Just reach out.</p>

            <p style="margin-top: 24px;">Thanks,<br><strong>TanzaniaBiz</strong></p>
        </div>

        <div class="footer">
            <p>Questions? Email us at info@tanzaniabiz.com</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}</p>
        </div>
    </div>
</body>

</html>
