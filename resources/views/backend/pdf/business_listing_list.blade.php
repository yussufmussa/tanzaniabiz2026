<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listing Approved - TanzaniaBiz</title>
    <style>
        body {
            font-family: Georgia, Times, serif;
            line-height: 1.7;
            color: #333;
            background-color: #ffffff;
            margin: 0;
            padding: 20px;
        }

        .email-container {
            max-width: 650px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #ddd;
        }

        .header {
            background-color: #2c3e50;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            border-bottom: 3px solid #34495e;
        }

        .header h1 {
            font-size: 22px;
            margin: 0;
            font-weight: normal;
            letter-spacing: 1px;
        }

        .header p {
            font-size: 13px;
            margin: 5px 0 0 0;
            font-style: italic;
        }

        .content {
            padding: 35px 40px;
        }

        .success-notice {
            border: 2px solid #27ae60;
            padding: 15px;
            margin-bottom: 25px;
            background-color: #f9f9f9;
        }

        .success-notice p {
            margin: 0;
            color: #27ae60;
            font-weight: bold;
        }

        .company-name {
            font-weight: bold;
            text-decoration: underline;
        }

        .content p {
            margin-bottom: 15px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 15px;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
        }

        .notice-box {
            border: 1px solid #3498db;
            padding: 20px;
            margin: 20px 0;
            background-color: #f8f9fa;
        }

        .notice-box h4 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 15px;
        }

        .notice-box ul {
            margin: 10px 0;
            padding-left: 25px;
        }

        .notice-box li {
            margin-bottom: 5px;
        }

        ul {
            margin: 10px 0;
            padding-left: 25px;
        }

        ul li {
            margin-bottom: 8px;
        }

        .login-link {
            display: inline-block;
            margin: 20px 0;
            padding: 12px 25px;
            background-color: #2c3e50;
            color: #ffffff;
            text-decoration: none;
            border: 2px solid #2c3e50;
        }

        .login-link:hover {
            background-color: #ffffff;
            color: #2c3e50;
        }

        .footer {
            background-color: #ecf0f1;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #bdc3c7;
            font-size: 13px;
        }

        .footer p {
            margin: 5px 0;
            color: #7f8c8d;
        }

        hr {
            border: none;
            border-top: 1px solid #ddd;
            margin: 25px 0;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>TANZANIABIZ</h1>
            <p>List of Local Business</p>
        </div>

        <div class="content">
            <div class="success-notice">
                <p>LISTING APPROVED</p>
            </div>

            <p>Dear {{ $listing->name }},</p>

            <p>Your business listing 
            <span class="company-name">
                <a href="{{ $listing->name }}" target="_blank">{{ $listing->name }}</a>
            </span> has been approved and is now active on TanzaniaBiz.
            </p>
            @php
                $hasPhotos = $listing->photos?->count() > 0;
                $hasProducts = $listing->products?->count() > 0;
                $hasExtraInfo = $listing->workingHours?->count() > 0 || $listing->socialMedia?->count() > 0;
                $isComplete = $hasPhotos && $hasProducts && $hasExtraInfo;
            @endphp
            @if (!$hasPhotos || !$hasProducts || !$hasExtraInfo)
                <div class="notice-box">
                    <h4>Complete Your Business Profile</h4>
                    <p>To maximize visibility and attract more customers, please ensure all sections of your listing are
                        complete. The following information is currently not filled:</p>
                    <ul>
                        @if (!$hasPhotos)
                            <li>Business Photos</li>
                        @endif
                        @if (!$hasProducts)
                            <li>Business Products</li>
                        @endif
                        @if (!$hasExtraInfo)
                            <li>Business Social or Working hours</li>
                        @endif
                        
                    </ul>
                    <p><strong>Note:</strong> Complete listings receive significantly more customer inquiries.</p>
                </div>
            <p>Login to your account to access these features and manage your listings.</p>
            <center>
                <a href="https://tanzaniabiz.com/login" class="login-link" target="_blank">LOGIN TO YOUR ACCOUNT</a>
            </center>
            @endif

            <p class="section-title">Your Account Benefits</p>

            <p>With your TanzaniaBiz account, you can:</p>

            <ul>
                <li>Create up to 3 business listings</li>
                <li>Post employment opportunities</li>
                <li>Manage listing visibility settings</li>
                <li>Update business information at any time</li>
            </ul>

            <hr>

            <p class="section-title">Free Online Business Tools</p>
            <ul>
                <li><a href="/invoice-generator" target="_blank">Invoice Generator</a></li>
                <li><a href="/qr-code-generator" target="_blank">Qr Code Generator</a></li>
            </ul>
          
            <p style="margin-top: 30px;">Should you require any assistance, please do not hesitate to contact us.</p>

            <p>Sincerely,</p>
            <p><strong>TanzaniaBiz</strong></p>
        </div>

        <div class="footer">
            <p>For inquiries, please contact us at info@tanzaniabiz.com</p>
            <p>&copy; {{ date('Y') }} {{ config(app.name) }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
