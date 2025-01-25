@extends('master')

@section('dashboard', 'active')

@section('content')
<div class="container mt-5">
    <div class="text-center">
        <h1 class="mb-4 text-primary">Welcome to Our Subscription Platform</h1>
        <p class="lead text-muted">
            Our website offers an array of subscription plans tailored to meet your needs. 
            Whether you're an individual looking for basic features, a professional seeking advanced tools, 
            or a business aiming to empower your team, we have the right plan for you. 
        </p>
    </div>

    <div class="mt-5 mb-5 text-center">
        <a href="{{ route('subscriptions.index') }}" class="btn btn-primary btn-lg rounded-pill shadow-sm">
            Explore Subscription Plans
        </a>
    </div>
</div>
@endsection
