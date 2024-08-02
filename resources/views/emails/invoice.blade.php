<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
</head>
<body>
    <h1>Invoice #{{ $invoice->id }}</h1>
    <p>Dear {{ $invoice->customer_name }},</p>
    <p>Thank you for your purchase. Please find the details of your invoice below:</p>
    <p>Total Amount: {{ $invoice->grand_total }}</p>
    <p>Thank you for doing business with us!</p>
</body>
</html>
