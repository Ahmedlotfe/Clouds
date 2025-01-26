<!-- resources/views/invoice.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1, h4 {
            text-align: center;
        }
        .details {
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <h1>Invoice</h1>
    <div class="details">
        <p><strong>Subscription Plan:</strong> {{ $order->plan->name }}</p>
        <p><strong>Price:</strong> ${{ number_format($order->total_price, 2) }}</p>
        <p><strong>Status:</strong> Paid</p>
        <p><strong>Subscription Duration:</strong> {{ $order->plan->duration }} Days</p>
        <p><strong>Subscription Start Date:</strong> {{ now()->toDateString() }}</p>
        <p><strong>Subscription End Date:</strong> {{ now()->addDays($order->plan->duration)->toDateString() }}</p>

    </div>
</body>
</html>