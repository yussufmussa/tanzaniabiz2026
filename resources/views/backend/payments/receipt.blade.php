<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Official Receipt</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            margin: 40px;
            color: #000;
        }

        .receipt {
            max-width: 210mm;
            margin: 0 auto;
        }

        /* ----- HEADER ----- */
        .header {
            text-align: center;
            padding-bottom: 20px;
            margin-bottom: 25px;
            border-bottom: 2px solid #000;
        }

        .company-name {
            font-size: 22pt;
            font-weight: bold;
        }

        .contact-info {
            font-size: 11pt;
            margin-top: 5px;
        }

        .receipt-title {
            font-size: 16pt;
            font-weight: bold;
            margin-top: 15px;
            letter-spacing: 1px;
            text-decoration: underline;
        }

        /* ----- SECTION TITLES ----- */
        .section-title {
            font-size: 13pt;
            font-weight: bold;
            margin: 30px 0 10px 0;
        }

        /* ----- TABLE LAYOUT ----- */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 6px 0;
        }

        .info-table td:first-child {
            width: 30%;
            font-weight: bold;
        }

        /* ----- AMOUNT BOX ----- */
        .amount-box {
            text-align: center;
            padding: 20px 0;
            margin: 30px 0;
            border: 1px solid #000;
            background: #f8f8f8;
        }

        .amount-label {
            font-size: 11pt;
            margin-bottom: 8px;
        }

        .amount {
            font-size: 24pt;
            font-weight: bold;
        }

        /* ----- SIGNATURE ----- */
        .signature-section {
            margin-top: 50px;
            text-align: left;
        }

        .signature-line {
            width: 250px;
            border-top: 1px solid #000;
            margin-top: 50px;
            padding-top: 5px;
            font-size: 10pt;
            text-align: center;
        }

        /* ----- FOOTER ----- */
        .footer {
            margin-top: 40px;
            font-size: 10pt;
            text-align: center;
            color: #333;
            border-top: 1px solid #000;
            padding-top: 10px;
        }

        @media print {
            body { margin: 20px; }
        }
    </style>
</head>

<body>
<div class="receipt">

    <!-- HEADER -->
    <div class="header">
        <div class="company-name">YOUR COMPANY NAME</div>
        <div class="contact-info">P.O. Box 12345, Dar es Salaam, Tanzania</div>
        <div class="contact-info">Tel: +255 XXX XXX XXX | Email: info@company.co.tz</div>
        <div class="receipt-title">PAYMENT RECEIPT</div>
    </div>

    <!-- RECEIPT INFO -->
    <div class="section-title">Receipt Details</div>
    <table class="info-table">
        <tr><td>Receipt No:</td><td>{{ $payment->payment_reference }}</td></tr>
        <tr><td>Date:</td><td>{{ $payment->created_at->format('d/m/Y') }}</td></tr>
        <tr><td>Time:</td><td>{{ $payment->created_at->format('H:i') }}</td></tr>
        <tr><td>Order Reference:</td><td>#{{ $payment->order->order_number }}</td></tr>
    </table>

    <!-- PAYER INFO -->
    <div class="section-title">Received From</div>
    <table class="info-table">
        <tr><td>Name:</td><td>{{ $payment->user->name }}</td></tr>
        <tr><td>Email:</td><td>{{ $payment->user->email }}</td></tr>
        @if(isset($payment->user->phone))
        <tr><td>Phone:</td><td>{{ $payment->user->phone }}</td></tr>
        @endif
    </table>

    <!-- AMOUNT BOX -->
    <div class="amount-box">
        <div class="amount-label">Amount Received</div>
        <div class="amount">{{ $payment->currency }} {{ number_format($payment->amount, 2) }}</div>
    </div>

    <!-- PAYMENT METHOD -->
    <div class="section-title">Payment Details</div>
    <table class="info-table">
        <tr><td>Payment Method:</td><td>{{ $payment->payment_method }}</td></tr>

        @if($payment->payment_account)
        <tr><td>Account / Number:</td><td>{{ $payment->payment_account }}</td></tr>
        @endif

        @if($payment->confirmation_code)
        <tr><td>Confirmation Code:</td><td>{{ $payment->confirmation_code }}</td></tr>
        @endif

        <tr><td>Status:</td><td>{{ strtoupper($payment->payment_status) }}</td></tr>
    </table>

    <!-- SIGNATURE -->
    <div class="signature-section">
        <div class="signature-line">Authorized Signature</div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        This is a system-generated receipt.<br>
        Printed on: {{ now()->format('d/m/Y H:i') }}
    </div>

</div>
</body>
</html>
