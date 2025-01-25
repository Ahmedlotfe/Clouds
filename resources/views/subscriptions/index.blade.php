@extends('master')

@section('plans', 'active')

@section('content')
<div class="container mt-5">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h1 class="text-center mb-4">Choose Your Subscription</h1>
    <div class="row g-4">
        @foreach ($plans as $plan)
        <div class="col-md-4">
            <div class="card shadow rounded-4">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold text-primary">{{ $plan->name }}</h5>
                    <p class="card-text text-muted">{{ $plan->description }}</p>
                    <h3 class="text-success fw-bold">${{ $plan->price }}</h3>
                    <p class="text-muted">Duration: {{ $plan->duration }} days</p>
                    <form method="GET" action="{{ route('redirectToStripe', $plan->id) }}">
                        <button type="submit" class="btn btn-primary mt-3 rounded-pill">Subscribe Now</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
