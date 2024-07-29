@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Stock Purchases</h1>
    <a href="{{ route('stock-purchases.create') }}" class="btn btn-primary mb-3">Add Stock Purchase</a>
    <ul class="list-group mt-3" id="purchaseList">
        @foreach($purchases as $purchase)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $purchase->item->name }} ({{ $purchase->category->name }}) - {{ $purchase->date }}
                <button class="btn btn-danger btn-sm" onclick="deletePurchase({{ $purchase->id }})">Delete</button>
            </li>
        @endforeach
    </ul>
</div>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    function deletePurchase(id) {
        axios.delete(`/stock-purchases/${id}`)
            .then(() => {
                const item = document.querySelector(`[onclick="deletePurchase(${id})"]`).parentElement;
                item.remove();
            })
            .catch(error => console.error(error));
    }
</script>
@endsection
