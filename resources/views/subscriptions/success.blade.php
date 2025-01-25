<!-- resources/views/checkout/success.blade.php -->
@extends('master')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Payment Successful!</h1>

    <div class="alert alert-success text-center">
        <strong>Thank you for your subscription!</strong>
        Your payment was successful. Below are the details of your subscription.
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Invoice</h4>
                </div>
                <div class="card-body">
                    <p><strong>Subscription Plan:</strong> {{ $order->plan->name }}</p>
                    <p><strong>Price:</strong> ${{ number_format($order->total_price, 2) }}</p>
                    <p><strong>Status:</strong> Paid</p>
                    <p><strong>Subscription Duration:</strong> {{ $order->plan->duration }} Days</p>
                    <p><strong>Subscription Start Date:</strong> {{ now()->toDateString() }}</p>
                </div>
                <div class="card-footer text-muted">
                    <p>If you have any questions, feel free to contact our support team.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
