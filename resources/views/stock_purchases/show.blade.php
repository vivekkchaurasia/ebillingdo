@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Stock Purchase Details</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $stockPurchase->item->name }}</h5>
            <p class="card-text">
                Category: {{ $stockPurchase->category->name }}<br>
                Date: {{ $stockPurchase->date }}<br>
                Batch No: {{ $stockPurchase->batch_no }}<br>
                Wholesale Price: {{ $stockPurchase->wholesale_price }}<br>
                Retail Price: {{ $stockPurchase->retail_price }}<br>
            </p>
        </div>
    </div>
    <a href="{{ route('stock-purchases.index') }}" class="btn btn-primary mt-3">Back to List</a>
</div>
@endsection
