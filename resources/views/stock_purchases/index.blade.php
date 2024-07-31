@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Stock Purchases</h1>
    <a href="{{ route('stock-purchases.create') }}" class="btn btn-primary mb-3">Add Stock Purchase</a>
    <table class="table table-bordered">
        <thead class="bg-info text-white">
            <tr>
                <td>Item Name</td>
                <td>Item Category</td>
                <td>Purchase Date</td>
                <td>Action</td>
            </tr>
        <tbody>
        @foreach($purchases as $purchase)
            <tr>
                <td>{{ $purchase->item->name }}</td>
                <td>{{ $purchase->itemCategory->name }}</td>
                <td>{{ $purchase->created_at }}</td>
                <td>
                    <a href="{{ route('stock-purchases.edit', $purchase->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <button class="btn btn-danger btn-sm" onclick="deletePurchase({{ $purchase->id }})">Delete</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
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
